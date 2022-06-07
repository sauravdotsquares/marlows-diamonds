<table width="100%" border="0" cellspacing="0" cellpadding="3" style="font-family:Arial; max-width: 800px; margin: auto;">
	<tbody>
		<tr>
                  <td >
				  <img src="{{asset('')}}assets/images/logo.png" style="width: 150; margin:15px;"/></td>
        </tr>
		<tr>
			<td style="color: #000; font-size: 15px;font-family:Arial; border-bottom: 1px solid #A0A0A0; padding: 13px 0 10px 0 ">
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0; line-height: 30px;"><b style="color: #000; font-size: 15px;font-family:Arial;">Name</b></p>
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0;">{{ isset($title)?$title:$name }}</p>
			</td>
		</tr>
		<tr>
			<td style="color: #000; font-size: 15px;font-family:Arial; border-bottom: 1px solid #A0A0A0; padding: 13px 0 10px 0 ">
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0; line-height: 30px;"><b style="color: #000; font-size: 15px;font-family:Arial;">URL</b></p>
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0;">
					<a style="color: #8E2E65; font-size: 15px;font-family:Arial; margin: 0; text-decoration: none;" href="javascript:void(0);">{{ isset($url)?$url:'' }}</a></p>
			</td>
		</tr>
        <tr>
			<td style="color: #000; font-size: 15px;font-family:Arial; border-bottom: 1px solid #A0A0A0; padding: 13px 0 10px 0 ">
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0; line-height: 30px;"><b style="color: #000; font-size: 15px;font-family:Arial;">Email</b></p>
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0;">
					<a style="color: #8E2E65; font-size: 15px;font-family:Arial; margin: 0; text-decoration: none;" href="mailto:{{ isset($email)?$email:'' }}">{{ isset($email)?$email:'' }}</a></p>
			</td>
		</tr>
		<tr>
			<td style="color: #000; font-size: 15px;font-family:Arial; border-bottom: 1px solid #A0A0A0; padding: 13px 0 10px 0 ">
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0; line-height: 30px;"><b style="color: #000; font-size: 15px;font-family:Arial;">Contact</b></p>
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0;">
					<a style="color: #8E2E65; font-size: 15px;font-family:Arial; margin: 0; text-decoration: none;" href="tel:{{ isset($phone)?$phone:'' }}">{{ isset($phone)?$phone:'' }}</a></p>
			</td>
		</tr>
		<tr>
			<td style="color: #000; font-size: 15px;font-family:Arial; border:none; padding: 13px 0 10px 0 ">
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0; line-height: 30px;"><b style="color: #000; font-size: 15px;font-family:Arial;">Your Message</b></p>
				<p style="color: #000; font-size: 15px;font-family:Arial; margin: 0; line-height: 30px;">
					{{ isset($user_query)?$user_query:'' }}
				</p>
			</td>
		</tr>
	</tbody>
</table>
