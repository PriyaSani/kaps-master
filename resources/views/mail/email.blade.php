<table>
	<tr>
		<td>
			<?php echo $bodymessage; ?>
		
			<a href="{{ route('mr.auth.password.reset', ['token' => $token , 'email' => $mr_data->email]) }}"><button value='<?php echo $mr_data->id; ?>'>Change Password</button></a><br>
		
			<?php echo $signature_message; ?>
		</td>
	</tr>
</table>