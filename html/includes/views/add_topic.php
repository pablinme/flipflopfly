<form id="addTopic">
	<fieldset>
		<span class="btn btn-info disabled">new topic !</span>
		</br>
		<input type="hidden" name="categoryID" id="categoryID" value="<?= $category; ?>" />
		<div class="input-append">
			<input class="input-large" id="subject" name="subject" maxlength="50" required="required" type="text" placeholder="">
			<a id='add_topic' class="btn">
				<i class="icon-ok"></i></a>
		</div>
	</fieldset>
</form>
		