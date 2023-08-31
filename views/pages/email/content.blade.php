<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
		<meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
		<title></title>

		<style type="text/css">
		body {
		margin: 0;
		padding: 0;
		-ms-text-size-adjust: 100%;
		-webkit-text-size-adjust: 100%;
		}

		table {
		border-spacing: 0;
		}

		table td {
		border-collapse: collapse;
		}

		.ExternalClass {
		width: 100%;
		}

		.ExternalClass,
		.ExternalClass p,
		.ExternalClass span,
		.ExternalClass font,
		.ExternalClass td,
		.ExternalClass div {
		line-height: 100%;
		}

		.ReadMsgBody {
		width: 100%;
		background-color: #ebebeb;
		}

		table {
		mso-table-lspace: 0pt;
		mso-table-rspace: 0pt;
		}

		img {
		-ms-interpolation-mode: bicubic;
		}

		.yshortcuts a {
		border-bottom: none !important;
		}

		@media screen and (max-width: 599px) {
		table[class="force-row"],
		table[class="container"] {
			width: 100% !important;
			max-width: 100% !important;
		}
		}
		@media screen and (max-width: 400px) {
		td[class*="container-padding"] {
			padding-left: 12px !important;
			padding-right: 12px !important;
		}
		}
		.ios-footer a {
		color: #aaaaaa !important;
		text-decoration: underline;
		}
		</style>

	</head>
	<body style="margin:0; padding:0;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

		<!-- 100% background wrapper (grey background) -->
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
		<tr>
			<td align="center" valign="top" bgcolor="#EBEBEB" style="background-color: #EBEBEB;">
			<br>
			<!-- 600px container (white background) -->
			<table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px">
				<!-- <tr>
					<td class="container-padding header" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:24px;font-weight:bold;padding-bottom:12px;color:#DF4726;padding-left:24px;padding-right:24px">
						<img src="https://data.bappenas.go.id/assets/images/logo-bappenas.png" width="100"/>
						<div style="float:right;"><h6>Data Bappenas</h6></div>
					</td>
				</tr> -->
				<tr>
				<td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#ffffff">
					<br>
					<div class="title" style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:600;color:#374550">Kepada Yth. Bapak/Ibu di tempat,</div>
					<br>
					@foreach($user as $row)
						<div class="body-text" style="font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
						Melalui email ini kami sampaikan bahwa terdapat pengajuan permohonan data terbaru dari user di Data Bappenas.
						<br><br>
						Nomor SP: <strong>{{$row->ladu_no . '/P02.SP/' . date('m/Y', strtotime($row->request_date))}}</strong>
						<br>
						Tanggal: <strong>{{(date('d-m-Y H:i:s', strtotime($row->request_date)))}}</strong>
						<br>
						Data yang diminta:<br>
						<ul style="line-height:10px;">
						@foreach($row->files as $files)
							<li>{{ $files->name }}</li></br>
						@endforeach
						</ul>
						Pemohon: <strong>{{$row->name}}</strong>
					@endforeach
					<br><br>
					<center>
						<h3>( <a style="color:#DF4726;" href="https://dev.bappenas.go.id/datamikro/listtersedia">Klik di sini untuk menindaklanjuti</a> )</h3>
					</center>
					<br>
					<span style="color:gray;">
						<p>
						Ini adalah pesan otomatis, jangan membalas langsung melalui tombol "Reply"!</br>
						Anda menerima email ini karena terdaftar sebagai administrator di situs data.bappenas.go.id.
						</p>
					</span>
					<hr>
					<span style="font-family:Helvetica, Arial, sans-serif;font-size:18px;font-weight:500;color:#374550;text-align:center;">
						<p>
						Kementerian PPN/Bappenas<br/>
						Jln. Taman Suropati, No. 2, Menteng, Jakarta, 10310</br>
						Telp. 021-3905650 | Helpdesk Pusdatin: ext. 2307/1403
						</p>
						<br>
					</span>
					</div>
				</td>
				</tr>
			</table>
			<!--/600px container -->
			<br>
			</td>
		</tr>
		</table>
		<!--/100% background wrapper-->

	</body>
</html>