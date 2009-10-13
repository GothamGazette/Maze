<?php
if (false === class_exists('Badge_helper'))
{
    class Badge_helper
    {
        const POINTS_FONT = 'PlantagenetCherokee.ttf';
        const OUTPUT_FOLDER = 'images/badges';

        public function getImageMagickCommand(&$gamesession)
        {
            $ci = &get_instance();

            $public_dir = self::getPublicDirectoryPath();

            $badge_points = (1 == $gamesession->completed) ? $gamesession->points * $gamesession->time_remaining : 0;

            $image = self::getBadgeBackground($badge_points, $gamesession->level_id);

            $target_image = $public_dir . DIRECTORY_SEPARATOR . self::OUTPUT_FOLDER . DIRECTORY_SEPARATOR . $gamesession->hash;
            $source_image = $public_dir . DIRECTORY_SEPARATOR . $image;

            $command = $ci->config->item('image_magick_path') . DIRECTORY_SEPARATOR . 'convert';
            $command .= ' -resize 265x140 "' . $source_image . '" -font "' . BASEPATH . 'fonts' . DIRECTORY_SEPARATOR . self::POINTS_FONT . '"'
            . ' -pointsize 21 -fill "#391c13" -draw "text 140, 95 \'' . $badge_points . '\'"'
            . ' "' . $target_image . '.png"';
            
            return $command;
        }
        
        public function createBadge(&$gamesession)
        {
            $command = self::getImageMagickCommand($gamesession);
            
            $retval = 1;
            
            @exec($command, $output, $retval);

            return (0 == $retval);
        }

        public function getBadgeBackground($points, $level)
        {
            $ci = &get_instance();

            $query = 'SELECT image FROM ' . $ci->db->protect_identifiers('badges')
            . ' WHERE level_id = ? AND minimum_points <= ?'
            . ' ORDER BY minimum_points DESC LIMIT 0,1';

            $rs = $ci->db->query($query, array($level, $points));

            if (0 < $rs->num_rows())
            {
                $row = $rs->row();
                return $row->image;
            }

            return null;
        }

        public function getPublicDirectoryPath()
        {
            $paths = explode(DIRECTORY_SEPARATOR, dirname(FCPATH));

            if ('public' !== $paths[(sizeof($paths)-1)])
            {
                $paths[] = 'public';
            }

            return implode(DIRECTORY_SEPARATOR, $paths);
        }

        public function displayBadge($gamesession)
        {
            $filename = self::getPublicDirectoryPath() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'badges' . DIRECTORY_SEPARATOR . $gamesession->hash . '.png';

            if (false === file_exists($filename))
            {
                if (false === self::createBadge($gamesession))
                {
                    show_404();    
                }
            }
            
            $request = getallheaders();
            $last_modified = filemtime($filename);

            if (isset($request['If-Modified-Since']))
            {
                // Split the If-Modified-Since (Netscape < v6 gets this wrong)
                $modified_since = explode(';', $request['If-Modified-Since']);

                // Turn the client request If-Modified-Since into a timestamp
                $modified_since = strtotime($modified_since[0]);
            }
            else
            {
                // Set modified since to 0
                $modified_since = 0;
            }

            // Issue an HTTP last modified header
            header('Expires: ' . gmdate('D, d M Y H:i:s', $last_modified+60*60*4) . ' GMT');
            header('Last-Modified: ' .gmdate('D, d M Y H:i:s', $last_modified) . ' GMT');
            header('Cache-control: public');
            header('Pragma: public');

            if ($last_modified <= $modified_since)
            {
                // Save on some bandwidth!
                header('HTTP/1.1 304 Not Modified');
                exit();
            }

            header('Content-type: image/png');
            header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
            header('Content-Length: ' . filesize($filename));
            //header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            $bytes = readfile($filename);
        }
    }
}
?>
