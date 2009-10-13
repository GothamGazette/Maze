<h1>Levels</h1>
<?php
foreach ($levels as $level)
{
?>
<div class="level">
	<?php echo ObjectHelper::dumpPublicProperties($level, array('id', 'css_class', 'ordering')); ?>
    
    <h2>Questions</h2>
<?php
	$questions = $this->all_levels->getQuestions($level->id);
	foreach ($questions as $question)
	{
?>
	<div class="question">
    	<?php echo ObjectHelper::dumpPublicProperties($question, array('id', 'action_function', 'target_image', 'target_pos_x', 'target_pos_y', 'target_height', 'target_width')); ?>
  		
        <h3>Responses</h3>  
<?php
		$responses = $this->all_levels->getResponses($question->id);
		foreach ($responses as $response)
		{
?> 
			<div class="response">
            	<?php echo ObjectHelper::dumpPublicProperties($response, array('id', 'question_id', 'more_information', 'image_pos_x', 'image_pos_y')); ?>
            </div>
<?php
		}
?>
    </div>
<?php
	}
?>
</div>
<?php
}
?>
