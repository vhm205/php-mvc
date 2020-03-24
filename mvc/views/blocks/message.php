<?php if(isset($data['errors']) && count($data['errors']) > 0) { ?>
		<div class="mb-4">
			<div class="card bg-danger text-white shadow">
				<div class="card-body" id="message-error">
					<?php foreach ($data['errors'] as $value): ?>
						<?php echo $value . '<br />'; ?>
					<?php endforeach ?>
				</div>
			</div>
		</div>
<?php } if(isset($data['success']) && $data['success'] !== ''){ ?>
		<div class="mb-4">
			<div class="card bg-success text-white shadow">
				<div class="card-body" id="message-success">
					<?php echo $data['success']; ?>
				</div>
			</div>
		</div>
<?php } ?>
