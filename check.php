<?php

/*
|--------------------------------------------------------------------------
| Statamic is a PHP Application
|--------------------------------------------------------------------------
|
| If you see this text, your server is not running PHP. You'll need to 
| contact your system administrator, webhost, or Google to enable it, 
| or maybe try a different host.
|
*/

$is_ready = TRUE;

/*
|--------------------------------------------------------------------------
| Error Reporting
|--------------------------------------------------------------------------
|
| Not everything we need can be checked by scripts, so we'll turn
| error reporting up to 11. In general, an error is going to mean 
| the server probably isn't ready.
|
*/

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors','1');

/*
|--------------------------------------------------------------------------
| Required Bits
|--------------------------------------------------------------------------
|
| These things are absolutely required to be able to use Statamic. You
| *might* be able to hack around Multibyte encoding if you don't use
| special characters in your URLs, but that's about it.
|
*/

$required = array(
	'PHP 5.3.6+' => version_compare(PHP_VERSION, '5.3.6', '>='),
	'PCRE and UTF-8 Support' => function_exists('preg_match') && @preg_match('/^.$/u', 'ñ') && @preg_match('/^\pL$/u', 'ñ'),
	'Multibyte Encoding' => extension_loaded('mbstring'),
	'Mcrypt' => extension_loaded('mcrypt')
);

/*
|--------------------------------------------------------------------------
| Recommended Bits
|--------------------------------------------------------------------------
|
| You don't *have* to have these things to run Statamic, but certain
| features will be broken, like image resizing/manipulation, or your
| URLs won't be able to hide the "index.php" in them if you're missing
| Mod Rewrite. Also, Mod Rewrite is a tricky thing to detect if you're
| running PHP as CGI. A fail doesn't necessarily mean it's missing.
|
*/

$recommended = array(
	'Mod Rewrite' => hasModRewrite('mod_rewrite'),
	'Timezone Set' => ini_get('date.timezone') !== '',
	'GD Library for image manipulation' => (extension_loaded('gd') && function_exists('gd_info')),
	'FileInfo Extension for image manipulation' => extension_loaded('fileinfo'),
	'cURL' => function_exists('curl_version')
);

foreach ($required as $feature => $pass) {
	if ($pass === FALSE) {
		$is_ready = FALSE;
	}
}

?><!doctype html>
<html>
	<head>
		<title>Statamic Server Check</title>
	    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:300,400,700">
		<style>
			/*! normalize.css v3.0.1 | MIT License | git.io/normalize */
			html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}body{margin:0}article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block}audio,canvas,progress,video{display:inline-block;vertical-align:baseline}audio:not([controls]){display:none;height:0}[hidden],template{display:none}a{background:0 0}a:active,a:hover{outline:0}abbr[title]{border-bottom:1px dotted}b,strong{font-weight:700}dfn{font-style:italic}h1{font-size:2em;margin:.67em 0}mark{background:#ff0;color:#000}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{top:-.5em}sub{bottom:-.25em}img{border:0}svg:not(:root){overflow:hidden}figure{margin:1em 40px}hr{-moz-box-sizing:content-box;box-sizing:content-box;height:0}pre{overflow:auto}code,kbd,pre,samp{font-family:monospace,monospace;font-size:1em}button,input,optgroup,select,textarea{color:inherit;font:inherit;margin:0}button{overflow:visible}button,select{text-transform:none}button,html input[type=button],input[type=reset],input[type=submit]{-webkit-appearance:button;cursor:pointer}button[disabled],html input[disabled]{cursor:default}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}input{line-height:normal}input[type=checkbox],input[type=radio]{box-sizing:border-box;padding:0}input[type=number]::-webkit-inner-spin-button,input[type=number]::-webkit-outer-spin-button{height:auto}input[type=search]{-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box}input[type=search]::-webkit-search-cancel-button,input[type=search]::-webkit-search-decoration{-webkit-appearance:none}fieldset{border:1px solid silver;margin:0 2px;padding:.35em .625em .75em}legend{border:0;padding:0}textarea{overflow:auto}optgroup{font-weight:700}table{border-collapse:collapse;border-spacing:0}td,th{padding:0}
			body {
				background: #039ad3;
	            color: #444;
	            font-family: 'Lato', sans-serif;
	            font-size: 14px;
	            height: 100%;
	            line-height: 20px;
	        }
			.column {
				float: left;
				position: relative;
				height: 100%;
				width: 50%;
			}
			.header {
				position: fixed;
				top: 0;
				left: 0;
				height: 100%;
				background: #fff;
			}
			.content {
				background: #039ad3;
				color: #fff;
				width: 50%;
				margin: 0 auto;
				height: auto;
				position: absolute;
				right: 0;
				text-align: center;
			}
			.not-ready, .not-ready .content, .not-ready .button:hover {
				background: #d94b38;
			}
			.not-ready h1 {
				color: #d94b38;
			} 
			.block {
				padding: 50px;
			}
			.check-table td {
				font-size: 21px;
			}
			.check-table td.fail {
				color: #fff600;
			}
			.footer {
				position: fixed;
				bottom: 25px;
				width: 50%;
				text-align: center;
			}
			.button {
				background: #222;
				display: block;
				width: 100%;
				padding: 20px 0;
				color: #fff;
				font-size: 32px;
				text-decoration: none;
				margin-bottom: 25px;
			}
			.button:hover {
				background: #039ad3;
			}
			h1 {
				color: #039ad3;
				font-size: 92px;
				line-height: 80px;
				font-weight: bold;
				text-transform: uppercase;
				letter-spacing: -7px;
				margin: 0;
			}
			h2 {
				font-size: 48px;
				font-weight: 300;
				line-height: 48px;
				letter-spacing: -1px;
			}
			h3 {
				font-size: 26px;
				padding: 25px 0;
				border-bottom: 1px solid #fff;
			}
			h6 {
				color: #444;
				font-size: 36px;
				font-weight: bold;
				margin: 10px 0 10px 5px;
			}
			p {
				font-size: 18px;
				font-weight: 300;
				line-height: 28px;
				margin: 0 0 15px 0;
			}
			p a {
				text-decoration: none;
				color: #039ad3;
				font-weight: bold;
			}
			table {
				text-align: right;
				line-height: 28px;
				width: 100%;
			}
			table td, table th {
				border-bottom: 1px solid rgba(255,255,255,.1);
				padding: 5px;
			}
			table tr:last-child td, table tr:last-child th {
				border-bottom: none;
			}
			table th {
				text-align: left;
				width: 60%;
			}
			@media only screen and (max-width: 800px) {
				.column {
					float: left;
					position: relative;
					height: auto;
					width: 100%;
					margin: 0 auto;
				}
				.header {
					position: relative;
					top: auto;
					left: auto;
					height: auto;
					background: #fff;
				}
				.content {
					background: #039ad3;
					color: #fff;
					width: 100%;
					margin: 0 auto;
					height: auto;
					position: relative;
					right: auto;
					text-align: center;
				}
				.footer {
					position: relative;
					bottom: auto;
					width: 100%;
					text-align: center;
				}
			}
		</style>
	</head>
	<body class="<?php echo ($is_ready) ? 'ready' : 'not-ready' ?>">
		
		<div class="column header">
			<div class="block">
				<h6>Statamic</h6>
				<h1>Server Check</h1>
			</div>
			<div class="footer">
				<div class="block">
					<?php if ($is_ready): ?>
						<a href="https://store.statamic.com" class="button">Buy a Statamic License</a>
						<p>Or you can check out the <a href="http://statamic.com/learn">documentation</a> to learn more.</p>
					<?php else: ?>
						<a href="https://github.com/statamic/hosts" class="button">Get a great web host.</a>
					<?php endif ?>
				</div>
			</div>
		</div>

		<div class="content column">
			<div class="block">
				<?php if ($is_ready): ?>
					<h2>This server is Statamic ready!</h2>
				<?php else: ?>
					<h2>This server isn't quite ready for Statamic.</h2>
				<?php endif; ?>
				
				<p>In case you like to know the nitty gritty details, here's what we look for in a server. It's kind of like dating, but more technical.</p>

				<h3>Requirements</h3>

				<table cellspacing="0" class="check-table">
					<?php foreach ($required as $label => $passed): ?>
						<tr>						
							<th class="label"><?php echo $label ?></th>
							<td class="<?php echo ($passed) ? 'pass' : 'fail' ?>"><?php echo ($passed) ? '&check;' : '&#x2717;' ?></td>
						</tr>	
					<?php endforeach ?>
				</table>

				<h3>Recommendations</h3>

				<table cellspacing="0" class="check-table">
					<?php foreach ($recommended as $label => $passed): ?>
						<tr>
							<th class="label"><?php echo $label ?></th>
							<td class="<?php echo ($passed) ? 'pass' : 'fail' ?>"><?php echo ($passed) ? '&check;' : '&#x2717;' ?></td>
						</tr>	
					<?php endforeach ?>
				</table>

				<h3>Useful Server Info</h3>

				<table cellspacing="0">
					<tr>
						<th>Max file upload size</th>
						<td><?php echo ini_get('upload_max_filesize') ?></td>
					</tr>
					<tr>
						<th>Max POST size</th>
						<td><?php echo ini_get('post_max_size') ?></td>
					</tr>
					<tr>
						<th>PHP Memory Limit</th>
						<td><?php echo ini_get('memory_limit') ?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>

<?php

	function hasApacheModule($module)
	{
		if (function_exists('apache_get_modules')) {
			return in_array($module, apache_get_modules());
		}

		return false;
	}

	function hasModRewrite()
	{
		$check = hasApacheModule('mod_rewrite');
		
		if ( ! $check && function_exists('shell_exec')) {
			$check = strpos(shell_exec('/usr/local/apache/bin/apachectl -l'), 'mod_rewrite') !== FALSE;
		}

		return $check;
	}
?>
