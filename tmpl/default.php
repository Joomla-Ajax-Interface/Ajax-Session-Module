<?php defined('_JEXEC') or die;

/**
 * File       default.php
 * Created    5/22/13 6:43 AM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2013 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v3 or later
 */

?>
<form action="submit.php" method="post" id="timeForm">
	<input type="text" name="dataInput">
	<input type="submit" class="add" value="Add Value" />
	<input type="submit" class="delete" value="Delete Value" />
	<input type="submit" class="destroy" value="Destroy Session" />
</form>
<div class="status"></div>