<?php

if ( ! file_exists("settings.ini")) {
	printf("No settings file found. Aborting");
	exit;
}

$settings = parse_ini_file("settings.ini");

// read token to get YAML file name
$file_name = null;
if (array_key_exists("token", $_REQUEST)) {
	$file_name = base64_decode($_REQUEST["token"]);
}


if ($file_name == null || ! file_exists($file_name)) {
	printf("YAML file {%s} for API not found", $file_name);
	exit;
}

// YAML parser
include('Spyc.php');
$brand_name = array_key_exists("brand.name", $settings) ? $settings["brand.name"] : "";
$api_version = array_key_exists("api.version", $settings) ? $settings["api.version"] : "v1.0";

$data = Spyc::YAMLLoad($file_name);

?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $data["description"] ?> </title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-wip/css/bootstrap.min.css">
	<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js?skin=desert"></script>
	<!-- <script src="js-modules/run_prettify.js"></script> -->
	<style> body { padding-top: 90px; } </style>

</head>

<body nload="prettyPrint()">
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-offset-1 col-lg-11">
			<nav class="navbar navbar-top" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse"
					        data-target=".navbar-ex5-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/"><?php echo $brand_name ?></a>
				</div>
			</nav>
		</div>
	</div>
	<!-- top toolbar  -->

	<div class="row">
		<div class="col-lg-offset-1 col-lg-8">
			<ol class="breadcrumb">
				<li><a href="/docs">Home</a></li>
				<li><a href="index.php"><?php echo $brand_name ?>&nbsp;REST API</a></li>
				<li class="active"> <?php echo $data["endpoint"] ?> </li>
			</ol>
		</div>

	</div>
	<!--  breadcrumbs  -->

	<div class="row">
		<div class="col-lg-1">&nbsp;</div>
		<div class="col-lg-11">
			<div class="page-header">
				<h1><?php echo $data["description"] ?></h1>

				<p>
					<span class="label label-info">API version <?php echo $data["version"] ?></span>
				</p>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-lg-1">&nbsp;</div>
		<div class="col-lg-8">

			<pre class="prettyprint"><strong>Endpoint: </strong><code><?php echo $data["endpoint"] ?></code> </pre>

			<div class="panel">

				<h4>HTTP Header</h4>
				<br>
				<table class="table">
					<tr>
						<th>Parameter</th>
						<th>Type</th>
						<th>Description</th>
						<th>Optional</th>
						<th>Default</th>
						<th>Values</th>
					</tr>
					<tbody>

					<?php
					if ($data['auth_type'] == 'required') { ?>
						<tr>
							<td><b><span style="color:red">Authorization</span></b></td>
							<td><i>String</i></td>
							<td>Application authentication</td>
							<td></td>
							<td></td>
							<td>Basic a1JvbGZzb25AZ21haWwuY29tOmthbHBhMTIz</td>
						</tr>
					<?php }
					if ($data['api_key'] == 'required') { ?>
						<tr>
							<td><b><span style="color:red">X-API-Key</span></b></td>
							<td><i>String</i></td>
							<td>API Key of the application</td>
							<td></td>
							<td></td>
							<td>UH8t3ENqmi4EdS6PgZWYGxO2sOoPdDhM</td>
						</tr>
					<?php }
					if ($data['access_token'] == 'required') { ?>
						<tr>
							<td><b><span style="color:red">X-Auth-Token</span></b></td>
							<td><i>String</i></td>
							<td>The valid Access Token</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					<?php }
					if ($data['device_id'] == 'required') { ?>
						<tr>
							<td><b><span style="color:red">X-Auth-Device</span></b></td>
							<td><i>String</i></td>
							<td>The Device ID</td>
							<td></td>
							<td></td>
							<td>02307032-d6a5-11e4-b9d6-1681e6b88ec1</td>
						</tr>
					<?php }
					if ($data['device_type'] == 'required') { ?>
						<tr>
							<td><b><span style="color:red">X-Auth-Device-Type</span></b></td>
							<td><i> String </i></td>
							<td>The Device Type</td>
							<td></td>
							<td></td>
							<td>APPLE</td>
						</tr>
					<?php }
					?>

					</tbody>
				</table>


				<hr>
				<h4>Input Parameters</h4>
				<br>
				<table class="table">
					<tr>
						<th>Parameter</th>
						<th>Type</th>
						<th>Description</th>
						<th>Optional</th>
						<th>Default</th>
						<th>Values</th>
					</tr>
					<tbody>


					<?php

					if (($data["parameters"]) != "") {
						foreach ($data["parameters"] as $param) { ?>
							<tr>
								<td><b> <?php echo $param["name"]; ?> </b></td>
								<td><i> <?php echo $param["type"]; ?> </i></td>
								<td> <?php echo $param["description"]; ?>  </td>
								<td> <?php if ($param["optional"]) {
										echo "True";
									} ?> </td>
								<td> <?php if ($param["default"]) {
										echo $param["default"];
									} ?></td>
								<td> <?php echo $param["values"]; ?></td>
							</tr>
						<?php }
					} ?>
					</tbody>
				</table>
			</div>

			<!-- <h3>Example</h3>

			<table class="table">
				<tbody>
					<tr>
                        <td><?php echo $data["method"] ?> </td>
                        <td><?php echo $data["sample_url"] ?> </td>
					</tr>
				</tbody>
			</table> -->

			<!-- <div>
                <h4> Request </h4>
                <pre> <code> <?php echo $data["sample_request"] ?> </code> </pre>
            </div> -->


			<div>
				<h4> Errors </h4>
				<pre class="prettyprint"> <code> <?php echo $data["errors"] ?> </code> </pre>
			</div>
			<div>
				<h4> Sandbox Errors </h4>
				<pre class=""
				     style="background-color:#cccccc">  <code><?php echo $data["sandbox_errors"] ?> </code> </pre>
			</div>

			<div>
				<a href="http://www.json-generator.com/ title=" JSON Generator"" target="_blank"><h4> JSON
					Generator </h4></a>
				<pre class="prettyprint"> <code> <?php highlight_string($data["json_generator"]) ?> </code> </pre>
			</div>
			<!-- <div>
                <h4> Sample Response </h4>
				<pre class="prettyprint"> <code> <?php highlight_string($data["sample_response"]) ?> </code> </pre>
            </div> -->

		</div>
		<!-- col-8 -->

		<div class="col-lg-2">
			<h3>Resource Information</h3>
			<table class="table">

				<tbody>
				<!-- <tr>
						<td><b>Rate Limited</b></td>
                        <td><?php if ($data["rate_limited"]) {
					echo "True";
				} else {
					echo "False";
				} ?></td>
					</tr> -->
				<tr>
					<?php
					if ($data["authentication"] == "required") { ?>
						<td><b>Authentication</b></td>
						<td>
							<?php
							echo '<span style="color:white; background:red; padding-left:5px; padding-right:5px;">' . $data["authentication"] . '</span>';
							?>
						</td>
					<?php }
					?>
				</tr>
				<tr>
					<td><b>Method</b></td>
					<td>
						<?php
						echo '<span style="color:white; background:#FF9933; padding-left:5px; padding-right:5px;">' . $data["method"] . '</span>';
						?>
					</td>
				</tr>
				<tr>
					<td><b>Response Format</b></td>
					<td>
						<?php
						echo '<span style="color:white; background:#99CC99; padding-left:5px; padding-right:5px;">' . $data["response_format"] . '</span>';
						?>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
		<!-- col:2 -->
	</div>
</div>
</body>
</html>
