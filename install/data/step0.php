<table id="installer-main">
	<tr>
		<td style="width: 185.717px; vertical-align: top;">
			<ul>
				<li>License</li>
			</ul>
		</td>
		<td>
			<p><h3>Welcome to EVEmu Portal installation wizard</h3></p>
			<p>Thank you for using EVEmu Portal.</p>
			<p><div id="license"><pre><?php include('license'); ?></pre></div></p>
			<p>To begin the installation you should agree to the license.</p>
			<p>
				<form method="POST" action="?step=1">
					<input type="submit" value="I Agree">
					<input type="reset" value="I Do Not Agree" onclick="location.href='http://google.com';">
				</form>
			</p>
		</td>
	</tr>
</table>