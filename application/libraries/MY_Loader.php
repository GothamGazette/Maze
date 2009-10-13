<?php

/**
 * Matchbox Loader class
 *
 * This file is part of Matchbox
 *
 * Matchbox is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * Matchbox is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   Matchbox
 * @copyright 2007-2008 Zacharias Knudsen
 * @license   http://www.gnu.org/licenses/gpl.html
 * @version   $Id: Loader.php 205 2008-02-24 01:43:55Z zacharias@dynaknudsen.dk $
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Replaces the CodeIgniter Loader class
 *
 * All code not encapsulated in {{{ Matchbox }}} was made by EllisLab
 *
 * @package   Matchbox
 * @copyright 2007-2008 Zacharias Knudsen
 * @license   http://www.gnu.org/licenses/gpl.html
 */

class MY_Loader extends CI_Loader
{
    // {{{ Matchbox

    /**
     * The Matchbox object
     *
     * @var    object
     * @access private
     */
    var $_matchbox;

    var $_ci_tables = array();
    
/**
     * Constructor
     *
     * Sets the path to the view files and gets the initial output buffering level
     *
     * @access    public
     */
    function MY_Loader()
    {
        // {{{ Matchbox

        $this->_matchbox = &load_class('Matchbox');
        $this->_ci_tables = array();
        
        parent::CI_Loader();
        // }}}

        $this->_ci_is_php5 = (floor(phpversion()) >= 5) ? TRUE : FALSE;
        $this->_ci_view_path = APPPATH.'views/';
        $this->_ci_ob_level  = ob_get_level();

        log_message('debug', "Loader Class Initialized");
    }
    
    /**
     * Loads library from module
     *
     * @param  string
     * @param  string
     * @param  mixed
     * @return void
     * @access public
     */
    function module_library($module, $library = '', $params = null)
    {
        return $this->library($library, $params, $module);
    }

    /**
     * Loads model from module
     *
     * @param  string
     * @param  string
     * @param  string
     * @param  mixed
     * @return void
     * @access public
     */
    function module_model($module, $model, $name = '', $db_conn = false)
    {
        return $this->model($model, $name, $db_conn, $module);
    }

    /**
     * Loads view from module
     *
     * @param  string
     * @param  string
     * @param  array
     * @param  bool
     * @return void
     * @access public
     */
    function module_view($module, $view, $vars = array(), $return = false)
    {
        return $this->view($view, $vars, $return, $module);
    }

    /**
     * Loads file from module
     *
     * @param  string
     * @param  string
     * @param  bool
     * @return void
     * @access public
     */
    function module_file($module, $path, $return = false)
    {
        return $this->file($path, $return, $module);
    }

    /**
     * Loads helper from module
     *
     * @param  string
     * @param  mixed
     * @return void
     * @access public
     */
    function module_helper($module, $helpers = array())
    {
        return $this->helper($helpers, $module);
    }

    /**
     * Loads plugin from module
     *
     * @param  string
     * @param  mixed
     * @return void
     * @access public
     */
    function module_plugin($module, $plugins = array())
    {
        return $this->plugin($plugins, $module);
    }

    /**
     * Loads script from module
     *
     * @param  string
     * @param  mixed
     * @return void
     * @access public
     */
    function module_script($module, $scripts = array())
    {
        return $this->script($scripts, $module);
    }

    /**
     * Loads language file from module
     *
     * @param  string
     * @param  mixed
     * @param  string
     * @return void
     * @access public
     */
    function module_language($module, $file = array(), $lang = '')
    {
        return $this->language($file, $lang, $module);
    }
    
    function module_table($module, $table, $vars = array())
    {
        return $this->table($table, $vars, $module);
    }

    /**
     * Loads config file from module
     *
     * @param  string
     * @param  string
     * @param  bool
     * @param  bool
     * @return void
     * @access public
     */
    function module_config($module, $file = '', $use_sections = false, $fail_gracefully = false)
    {
        return $this->config($file, $use_sections, $fail_gracefully, $module);
    }

    //}}}

    // --------------------------------------------------------------------

    /**
     * Class Loader
     *
     * This function lets users load and instantiate classes.
     * It is designed to be called from a user's app controllers.
     *
     * @access    public
     * @param    string    the name of the class
     * @param    mixed    the optional parameters
     * @return    void
     */
    function library($library = '', $params = NULL)
    {
        if ($library == '')
        {
            return FALSE;
        }

        // {{{ Matchbox

        $module = $this->_matchbox->argument(2);

        if (is_array($library)) {
            foreach ($library as $class) {
                $this->_ci_load_class($class, $params, $module);
            }
        } else {
            $this->_ci_load_class($library, $params, $module);
        }

        // }}}

        $this->_ci_assign_to_models();
    }

    function table($table = '', $params = NULL)
    {
        if (is_array($table))
        {
            foreach($table as $babe)
            {
                $this->table($babe);
            }
            return;
        }

        
        if ($table == '')
        {
            return;
        }
        
        $table = strtolower(str_replace(EXT, '', str_replace('_delegate', '', $table)).'_delegate');

        // Is the model in a sub-folder? If so, parse out the filename and path.
        if (strpos($table, '/') === FALSE)
        {
            $path = '';
        }
        else
        {
            $x = explode('/', $table);
            $model = end($x);
            unset($x[count($x)-1]);
            $path = implode('/', $x).'/';
        }

        if (in_array($table, $this->_ci_tables, TRUE))
        {
            return;
        }

        $table = strtolower($table);

        // {{{ Matchbox

        $module = $this->_matchbox->argument(2);

        if (!$filepath = $this->_matchbox->find('tables/' . $path . $table . EXT, $module)) {
            show_error('Unable to locate the table delegate you have specified: ' . $table);
        }

        // }}}

        if ( ! class_exists('table_delegate'))
        {
            load_class('table_delegate', FALSE);
        }

        // {{{ Matchbox

        require_once($filepath);

        // }}}

        $this->_ci_tables[] = $table;
    }

    // --------------------------------------------------------------------

    /**
     * Model Loader
     *
     * This function lets users load and instantiate models.
     *
     * @access    public
     * @param    string    the name of the class
     * @param    mixed    any initialization parameters
     * @return    void
     */
    function model($model, $name = '', $db_conn = FALSE)
    {
        if (is_array($model))
        {
            foreach($model as $babe)
            {
                $this->model($babe);
            }
            return;
        }

        if ($model == '')
        {
            return;
        }

        // Is the model in a sub-folder? If so, parse out the filename and path.
        if (strpos($model, '/') === FALSE)
        {
            $path = '';
        }
        else
        {
            $x = explode('/', $model);
            $model = end($x);
            unset($x[count($x)-1]);
            $path = implode('/', $x).'/';
        }

        if ($name == '')
        {
            $name = $model;
        }

        if (in_array($name, $this->_ci_models, TRUE))
        {
            return;
        }

        $CI =& get_instance();
        if (isset($CI->$name))
        {
            show_error('The model name you are loading is the name of a resource that is already being used: '.$name);
        }

        $model = strtolower($model);

        // {{{ Matchbox

        $module = $this->_matchbox->argument(3);

        if (!$filepath = $this->_matchbox->find('models/' . $path . $model . EXT, $module)) {
            show_error('Unable to locate the model you have specified: ' . $model);
        }

        // }}}

        if ($db_conn !== FALSE AND ! class_exists('CI_DB'))
        {
            if ($db_conn === TRUE)
            $db_conn = '';

            $CI->load->database($db_conn, FALSE, TRUE);
        }

        if ( ! class_exists('Model'))
        {
            load_class('Model', FALSE);
        }

        // {{{ Matchbox

        require_once($filepath);

        // }}}

        $model = ucfirst($model);

        $CI->$name = new $model();
        $CI->$name->_assign_libraries();

        $this->_ci_models[] = $name;
    }

    // --------------------------------------------------------------------

    /**
     * Load View
     *
     * This function is used to load a "view" file.  It has three parameters:
     *
     * 1. The name of the "view" file to be included.
     * 2. An associative array of data to be extracted for use in the view.
     * 3. TRUE/FALSE - whether to return the data or load it.  In
     * some cases it's advantageous to be able to return data so that
     * a developer can process it in some way.
     *
     * @access    public
     * @param    string
     * @param    array
     * @param    bool
     * @return    void
     */
    function view($view, $vars = array(), $return = FALSE)
    {
        // {{{ Matchbox

        $module = $this->_matchbox->argument(3);

        return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return), $module);

        // }}}
    }

    // --------------------------------------------------------------------

    /**
     * Load File
     *
     * This is a generic file loader
     *
     * @access    public
     * @param    string
     * @param    bool
     * @return    string
     */
    function file($path, $return = FALSE)
    {
        // {{{ Matchbox

        $module = $this->_matchbox->argument(2);

        return $this->_ci_load(array('_ci_path' => $path, '_ci_return' => $return), $module);

        // }}}
    }

    // --------------------------------------------------------------------

    /**
     * Load Helper
     *
     * This function loads the specified helper file.
     *
     * @access    public
     * @param    mixed
     * @return    void
     */
    function helper($helpers = array())
    {
        if ( ! is_array($helpers))
        {
            $helpers = array($helpers);
        }

        foreach ($helpers as $helper)
        {
            $helper = strtolower(str_replace(EXT, '', str_replace('_helper', '', $helper)).'_helper');

            if (isset($this->_ci_helpers[$helper]))
            {
                continue;
            }

            // {{{ Matchbox

            $module = $this->_matchbox->argument(1);

            if ($ext_helper = $this->_matchbox->find('helpers/' . config_item('subclass_prefix') . $helper . EXT, $module)) {
                $base_helper = BASEPATH . 'helpers/' . $helper . EXT;

                if (!file_exists($base_helper)) {
                    show_error('Unable to load the requested file: helpers/' . $helper . EXT);
                }

                include_once($ext_helper);
                include_once($base_helper);
            } elseif ($filepath = $this->_matchbox->find('helpers/' . $helper . EXT, $module, 2)) {
                include($filepath);
            } else {
                show_error('Unable to load the requested file: helpers/' . $helper . EXT);
            }

            // }}}

            $this->_ci_helpers[$helper] = TRUE;

        }

        log_message('debug', 'Helpers loaded: '.implode(', ', $helpers));
    }

    // --------------------------------------------------------------------

    /**
     * Load Plugin
     *
     * This function loads the specified plugin.
     *
     * @access    public
     * @param    array
     * @return    void
     */
    function plugin($plugins = array())
    {
        if ( ! is_array($plugins))
        {
            $plugins = array($plugins);
        }

        foreach ($plugins as $plugin)
        {
            $plugin = strtolower(str_replace(EXT, '', str_replace('_pi', '', $plugin)).'_pi');

            if (isset($this->_ci_plugins[$plugin]))
            {
                continue;
            }

            // {{{ Matchbox

            $module = $this->_matchbox->argument(1);

            if (!$filepath = $this->_matchbox->find('plugins/' . $plugin . EXT, $module, 2)) {
                show_error('Unable to load the requested file: plugins/' . $plugin . EXT);
            }

            include($filepath);

            // }}}

            $this->_ci_plugins[$plugin] = TRUE;
        }

        log_message('debug', 'Plugins loaded: '.implode(', ', $plugins));
    }

    // --------------------------------------------------------------------

    /**
     * Load Script
     *
     * This function loads the specified include file from the
     * application/scripts/ folder.
     *
     * NOTE:  This feature has been deprecated but it will remain available
     * for legacy users.
     *
     * @access    public
     * @param    array
     * @return    void
     */
    function script($scripts = array())
    {
        if ( ! is_array($scripts))
        {
            $scripts = array($scripts);
        }

        foreach ($scripts as $script)
        {
            $script = strtolower(str_replace(EXT, '', $script));

            if (isset($this->_ci_scripts[$script]))
            {
                continue;
            }

            // {{{ Matchbox

            $module = $this->_matchbox->argument(1);

            if (!$filepath = $this->_matchbox->find('scripts/' . $script . EXT, $module, 2)) {
                show_error('Unable to load the requested script: scripts/' . $script . EXT);
            }

            include($filepath);

            // }}}
        }

        log_message('debug', 'Scripts loaded: '.implode(', ', $scripts));
    }

    // --------------------------------------------------------------------

    /**
     * Loads a language file
     *
     * @access    public
     * @param    array
     * @param    string
     * @return    void
     */
    function language($file = array(), $lang = '')
    {
        $CI =& get_instance();

        if ( ! is_array($file))
        {
            $file = array($file);
        }

        foreach ($file as $langfile)
        {
            // {{{ Matchbox

            $module = $this->_matchbox->argument(2);

            $CI->lang->load($langfile, $lang, false, $module);

            // }}}
        }
    }

    // --------------------------------------------------------------------

    /**
     * Loads a config file
     *
     * @access    public
     * @param    string
     * @return    void
     */
    function config($file = '', $use_sections = FALSE, $fail_gracefully = FALSE)
    {
        $CI =& get_instance();

        // {{{ Matchbox

        $module = $this->_matchbox->argument(3);

        $CI->config->load($file, $use_sections, $fail_gracefully, $module);

        // }}}
    }

    // --------------------------------------------------------------------

    /**
     * Loader
     *
     * This function is used to load views and files.
     * Variables are prefixed with _ci_ to avoid symbol collision with
     * variables made available to view files
     *
     * @access    private
     * @param    array
     * @return    void
     */
    function _ci_load($_ci_data)
    {
        // Set the default data variables
        foreach (array('_ci_view', '_ci_vars', '_ci_path', '_ci_return') as $_ci_val)
        {
            $$_ci_val = ( ! isset($_ci_data[$_ci_val])) ? FALSE : $_ci_data[$_ci_val];
        }

        // Set the path to the requested file
        // {{{ Matchbox

        if ($_ci_path == '')
        {
            $_ci_ext  = pathinfo($_ci_view, PATHINFO_EXTENSION);
            $_ci_file = ($_ci_ext == '') ? $_ci_view . EXT : $_ci_view;
            $_ci_path = str_replace(APPPATH, '', $this->_ci_view_path) . $_ci_file;
            $search   = 1;
        }
        else
        {
            $_ci_x    = explode('/', $_ci_path);
            $_ci_file = end($_ci_x);
            $search   = 3;
        }

        $module = $this->_matchbox->argument(1);

        if (!$_ci_path = $this->_matchbox->find($_ci_path, $module, $search)) {
            show_error('Unable to load the requested file: ' . $_ci_file);
        }

        // }}}

        // This allows anything loaded using $this->load (views, files, etc.)
        // to become accessible from within the Controller and Model functions.
        // Only needed when running PHP 5

        if ($this->_ci_is_instance())
        {
            $_ci_CI =& get_instance();
            foreach (get_object_vars($_ci_CI) as $_ci_key => $_ci_var)
            {
                if ( ! isset($this->$_ci_key))
                {
                    $this->$_ci_key =& $_ci_CI->$_ci_key;
                }
            }
        }

        /*
         * Extract and cache variables
         *
         * You can either set variables using the dedicated $this->load_vars()
         * function or via the second parameter of this function. We'll merge
         * the two types and cache them so that views that are embedded within
         * other views can have access to these variables.
         */
        if (is_array($_ci_vars))
        {
            $this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $_ci_vars);
        }
        extract($this->_ci_cached_vars);

        /*
         * Buffer the output
         *
         * We buffer the output for two reasons:
         * 1. Speed. You get a significant speed boost.
         * 2. So that the final rendered template can be
         * post-processed by the output class.  Why do we
         * need post processing?  For one thing, in order to
         * show the elapsed page load time.  Unless we
         * can intercept the content right before it's sent to
         * the browser and then stop the timer it won't be accurate.
         */
        ob_start();

        // If the PHP installation does not support short tags we'll
        // do a little string replacement, changing the short tags
        // to standard PHP echo statements.

        if ((bool) @ini_get('short_open_tag') === FALSE AND config_item('rewrite_short_tags') == TRUE)
        {
            echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))).'<?php ');
        }
        else
        {
            include($_ci_path);
        }

        log_message('debug', 'File loaded: '.$_ci_path);

        // Return the file data if requested
        if ($_ci_return === TRUE)
        {
            $buffer = ob_get_contents();
            @ob_end_clean();
            return $buffer;
        }

        /*
         * Flush the buffer... or buff the flusher?
         *
         * In order to permit views to be nested within
         * other views, we need to flush the content back out whenever
         * we are beyond the first level of output buffering so that
         * it can be seen and included properly by the first included
         * template and any subsequent ones. Oy!
         *
         */
        if (ob_get_level() > $this->_ci_ob_level + 1)
        {
            ob_end_flush();
        }
        else
        {
            // PHP 4 requires that we use a global
            global $OUT;
            $OUT->append_output(ob_get_contents());
            @ob_end_clean();
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load class
     *
     * This function loads the requested class.
     *
     * @access    private
     * @param     string    the item that is being loaded
     * @param    mixed    any additional parameters
     * @return     void
     */
    function _ci_load_class($class, $params = NULL)
    {
        // Get the class name
        $class = str_replace(EXT, '', $class);

        // We'll test for both lowercase and capitalized versions of the file name
        foreach (array(ucfirst($class), strtolower($class)) as $class)
        {
            // {{{ Matchbox

            $module = $this->_matchbox->argument(2);

            if ($subclass = $this->_matchbox->find('libraries/' . config_item('subclass_prefix') . $class . EXT, $module)) {

                $baseclass = $this->_matchbox->find('libraries/' . $class . EXT, $module, 2);

                // }}}

                if ( ! file_exists($baseclass))
                {
                    log_message('error', "Unable to load the requested class: ".$class);
                    show_error("Unable to load the requested class: ".$class);
                }

                // Safety:  Was the class already loaded by a previous call?
                if (in_array($subclass, $this->_ci_classes))
                {
                    $is_duplicate = TRUE;
                    log_message('debug', $class." class already loaded. Second attempt ignored.");
                    return;
                }

                include($baseclass);
                include($subclass);
                $this->_ci_classes[] = $subclass;

                // {{{ Matchbox

                return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $module);

                // }}}
            }

            // Lets search for the requested library file and load it.
            $is_duplicate = FALSE;

            // {{{ Matchbox

            if ($filepath = $this->_matchbox->find('libraries/' . $class . EXT, $module, 2)) {
                if (in_array($class, $this->_ci_classes)) {
                    $is_duplicate = true;
                    log_message('debug', $class . ' class already loaded. Second attempt ignored.');
                    return;
                }

                include($filepath);
                $this->_ci_classes[] = $class;
                return $this->_ci_init_class($class, '', $params, $module);
            }

            // }}}

        } // END FOREACH

        // If we got this far we were unable to find the requested class.
        // We do not issue errors if the load call failed due to a duplicate request
        if ($is_duplicate == FALSE)
        {
            log_message('error', "Unable to load the requested class: ".$class);
            show_error("Unable to load the requested class: ".$class);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Instantiates a class
     *
     * @access    private
     * @param    string
     * @param    string
     * @return    null
     */
    function _ci_init_class($class, $prefix = '', $config = FALSE)
    {
        $class = strtolower($class);

        // Is there an associated config file for this class?
        // {{{ Matchbox

        $module = $this->_matchbox->argument(3);

        if ($config === null) {
            if ($filepath = $this->_matchbox->find('config/' . $class . EXT, $module)) {
                include($filepath);
            }
        }

        // }}}

        if ($prefix == '')
        {
            $name = (class_exists('CI_'.$class)) ? 'CI_'.$class : $class;
        }
        else
        {
            $name = $prefix.$class;
        }

        // Set the variable name we will assign the class to
        $classvar = ( ! isset($this->_ci_varmap[$class])) ? $class : $this->_ci_varmap[$class];

        // Instantiate the class
        $CI =& get_instance();
        if ($config !== NULL)
        {
            $CI->$classvar = new $name($config);
        }
        else
        {
            $CI->$classvar = new $name;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Autoloader
     *
     * The config/autoload.php file contains an array that permits sub-systems,
     * libraries, plugins, and helpers to be loaded automatically.
     *
     * @access    private
     * @param    array
     * @return    void
     */
    function _ci_autoloader()
    {
        // {{{ Matchbox

        $ci = &get_instance();
        $ci->matchbox = &load_class('Matchbox');
        $this->_matchbox = &$ci->matchbox;
        
        //}}}

        include(APPPATH.'config/autoload'.EXT);

        if ( ! isset($autoload))
        {
            return FALSE;
        }

        // Load any custom config file
        if (count($autoload['config']) > 0)
        {
            // {{{ Matchbox

            foreach ($autoload['config'] as $key => $value) {
                if (is_string($key)) {
                    if (is_array($value)) {
                        foreach ($value as $config) {
                            $ci->config->module_load($key, $config);
                        }
                    } else {
                        $ci->config->module_load($key, $value);
                    }
                } else {
                    $ci->config->load($value);
                }
            }

            // }}}
        }

        // Autoload plugins, helpers, scripts and languages
        foreach (array('helper', 'plugin', 'script', 'language') as $type)
        {
            if (isset($autoload[$type]) AND count($autoload[$type]) > 0)
            {

                // {{{ Matchbox

                foreach ($autoload[$type] as $key => $value) {
                    if (is_string($key)) {
                        $this->{'module_' . $type}($key, $value);
                    } else {
                        $this->$type($value);
                    }
                }

                // }}}
            }
        }



        // A little tweak to remain backward compatible
        // The $autoload['core'] item was deprecated
        if ( ! isset($autoload['libraries']))
        {
            $autoload['libraries'] = $autoload['core'];
        }

        // Load libraries
        if (isset($autoload['libraries']) AND count($autoload['libraries']) > 0)
        {
            // Load the database driver.
            if (in_array('database', $autoload['libraries']))
            {
                $this->database();
                $autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
            }

            // Load scaffolding
            if (in_array('scaffolding', $autoload['libraries']))
            {
                $this->scaffolding();
                $autoload['libraries'] = array_diff($autoload['libraries'], array('scaffolding'));
            }

            // {{{ Matchbox

            foreach ($autoload['libraries'] as $key => $value) {
                if (is_string($key)) {
                    $this->module_library($key, $value);
                } else {
                    $this->library($value);
                }
            }

            // }}}

        }

        // {{{ Matchbox

        if (isset($autoload['model'])) {
            foreach ($autoload['model'] as $key => $value) {
                if (is_string($key)) {
                    $this->module_model($key, $value);
                } else {
                    $this->model($value);
                }
            }
        }

        // }}}

    }
}

?>