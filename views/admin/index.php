<section class="title">
	<h4><?php echo lang('slides.index_title'); ?></h4>
</section>
<section class="item">
	<div class="content">
		<?php if($entries['total'] > 0) : ?>
			<?php echo form_open('admin/slider/batch/'); ?>
			<table border="0" class="table-list" cellspacing="0">
				<thead>
					<tr>
						<th><?php
							echo form_checkbox(array(
								'name' => 'action_to_all',
								'class' => 'check-all'
							));
						?></th>
						<th>Beschriftung</th>
						<th>Linkt auf:</th>
						<th>Platkette</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($entries['entries'] as $entry) : ?>
					<tr>
						<td><?php echo form_checkbox('action_to[]', $entry['id']) ?></td>
						<td><?php echo $entry['label']; ?></td>
						<td><code><?php echo $entry['link']; ?></code></td>
						<td><?php echo $entry['ribbon']; ?></td>
						<td><?php
							switch($entry['status']['value']) {
								case "Live":
									echo '<span class="label green">live</span>';
								break 1;
								case "Draft":
									echo '<span class="label orange">draft</span>';
								break 1;
								default:
									echo '<span class="label">unbekannt</span>';
								break 1;
							}
						?></td>
						<td class="align-center">
							<div class="actions">
								<a href="<?php echo site_url('admin/slider/edit/'.$entry['id']); ?>" class="button edit">Bearbeiten</a>
								<a href="<?php echo site_url('admin/slider/delete/'.$entry['id']); ?>" class="button delete confirm">Löschen</a>
							</div>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			<div class="table_action_buttons">
				<button type="submit" name="btnAction" value="delete" class="btn red confirm" disabled="">
					<span>Markierte löschen</span>
				</button>
				<button type="submit" name="btnAction" value="unpublish" class="btn orange confirm" disabled="">
					<span>Als Entwurf markieren</span>
				</button>
				<button type="submit" name="btnAction" value="publish" class="btn blue confirm" disabled="">
					<span>Markierte veröffentlichen</span>
				</button>
			</div>
			<?php echo form_close(); ?>
		<?php else: ?>
			<div class="no_data">No entries.</div>
		<?php endif; ?>

	</div>
</section>