
<?php $this->setSiteTitle('Home');?>
<?php $this->start('head');?>
<meta name="tuandong" content="width=device-width, initial-scale=1.0">
<?php $this->end();?>

<?php $this->start('body'); ?>
<div class="row">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($data as $key => $value) {
				echo "<tr>";
				echo "<td>" . $value['fistName'] . "</td>";
				echo "<td>" . $value['lastName'] . "</td>";
				echo "<td>" . $value['Email'] . "</td>";
				echo "</tr>";
			}
			?>
			<tr>
				<td></td>
			</tr>
		</tbody>
	</table>
</div>
<?php $this->end();?>