<li>
	<a href="catalog.php?cat=<?=$category['id']?>"><?=$category['daughter']?></a>
	<?php if($category['childs']): ?>
		<ul>
			<?php echo category_to_string($category['childs']); ?>
		</ul>
	<?php endif; ?>
</li>

