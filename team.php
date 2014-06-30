<?php
	if (!defined("IN_SCRS")) {
		exit();
	}
?>
<div id="test">
	<input class="button back" type="button" value="返回" onclick="window.location='?exam=<?php echo $exam; ?>'" />
	<h3>题目</h3>
	<h3>队伍</h3>
	<form action="post_score.php" method="post">
		<input type="hidden" name="exam" value="题目" />
		<input type="hidden" name="team" value="队伍" />
		<div class="form_row_container">
			<span class="form_left">标准1</span>
			<input class="form_right" type="number" min="0" max="100" name="score[]" title="范围：0~10" placeholder="范围：0~10" autofocus required />
			<div class="form_desc">这里是标准1的具体内容（暂时先这么写好了，长一点会怎么样呢？）。</div>
		</div>
		<div class="form_row_container">
			<span class="form_left">标准2</span>
			<input class="form_right" type="number" min="0" max="100" name="score[]" title="范围：0~20" placeholder="范围：0~20" autofocus required />
			<div class="form_desc">这里是标准2的具体内容（暂时先这么写好了，长一点会怎么样呢？）。</div>
		</div>
		<div class="form_row_container">
			<span class="form_left">标准3</span>
			<input class="form_right" type="number" min="0" max="100" name="score[]" title="范围：0~20" placeholder="范围：0~20" autofocus required />
			<div class="form_desc">这里是标准3的具体内容（暂时先这么写好了，长一点会怎么样呢？）。</div>
		</div>
		<div class="form_row_container">
			<span class="form_left">标准4</span>
			<input class="form_right" type="number" min="0" max="100" name="score[]" title="范围：0~20" placeholder="范围：0~20" autofocus required />
			<div class="form_desc">这里是标准4的具体内容（暂时先这么写好了，长一点会怎么样呢？）。</div>
		</div>
		<div class="form_row_container">
			<span class="form_left">标准5</span>
			<input class="form_right" type="number" min="0" max="100" name="score[]" title="范围：0~30" placeholder="范围：0~30" autofocus required />
			<div class="form_desc">这里是标准5的具体内容（暂时先这么写好了，长一点会怎么样呢？）。</div>
		</div>
		<div class="form_row_container">
			<input class="button" type="submit" value="提交" />
		</div>
	</form>
</div>
