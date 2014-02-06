<?php
/*******************************************************************
*                                                                  *
* If you see this text, it means that your server is not running   *
* PHP. You can’t run Statamic.                                    *
*                                                                  *
* Ask your system administrator to install PHP.                    *
*                                                                  *
*******************************************************************/
?>
<?php
  $is_ready = true;

  if (version_compare(PHP_VERSION, '5.3.6', '>=') != true)
    $is_ready = false;

  $have_rewrite = apache_is_module_loaded('mod_rewrite');
  if ($have_rewrite != true)
    $is_ready = false;

  if ( ! function_exists('preg_match'))
     $is_ready = false;

  if ( ! @preg_match('/^.$/u', 'ñ'))
    $is_ready = false;

  if ( ! @preg_match('/^\pL$/u', 'ñ'))
    $is_ready = false;

?>
<!doctype html>
<html>
  <head>
    <title>Statamic Server Check</title>
    <link href='http://fonts.googleapis.com/css?family=Neuton:200,300|Crimson+Text:400,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://themes.statamic.com/london-wild/_themes/london-wild/css/london-wild.css" />
  </head>
  <body>
    <div class="container" style="margin-top:100px;">
      <div class="row">
        <div class="span8 offset2">
          <h1 id="logo">Statamic Server Check</h1>

          <hr/ >

          <?php if ($is_ready): ?>
            <h3 class="ready">Good job, son. Your server seems worthy. You are ready for Statamic.</h3>
          <?php else: ?>
            <?php if ($have_rewrite): ?>
              <h3 class="not-ready">Easy slugger, it seems that your server may not be ready for Statamic.</h3>
              <p>It would appear your server may NOT be ready to run Statamic (0.9)</p>
            <?php else: ?>
              <h3 class="not-ready">Curious, it seems that your server may not be ready.</h3>
              <p>We could not determine if Mod Rewrite was enabled or not</p>
            <?php endif ?>
          <?php endif; ?>

          <p>Here's what we looked at.</p>
          <br>

          <table cellspacing="0">
            <tr>
              <th class="label">PHP Version</th>
              <?php if (version_compare(PHP_VERSION, '5.3', '>=')): ?>
                <td class="sign pass">Pass</td>
                <td class="version"><?php echo PHP_VERSION ?></td>
                <td class="instructions"></td>
              <?php else: $failed = TRUE ?>
                <td class="sign fail">Failed</td>
                <td class="version"><?php echo PHP_VERSION ?></td>
                <td class="instructions exclam">Statamic requires PHP 5.3 or newer</td>
              <?php endif ?>
            </tr>

            <tr>
              <th class="label">PCRE UTF-8</th>
              <?php if ( ! function_exists('preg_match')): $failed = TRUE ?>
                <td class="sign fail">Failed</td>
                <td class="version red">PCRE support is missing</td>
                <td class="instructions exclam">Ask your system administrator to add <a href="http://php.net/pcre" target="_blank">PCRE</a> support to your server</td>
              <?php elseif ( ! @preg_match('/^.$/u', 'ñ')): $failed = TRUE ?>
                <td class="sign fail">Failed</td>
                <td class="version red">No UTF-8 support</td>
                <td class="instructions exclam"><a href="http://php.net/pcre" target="_blank">PCRE</a> has not been compiled with UTF-8 suppor.</td>
              <?php elseif ( ! @preg_match('/^\pL$/u', 'ñ')): $failed = TRUE ?>
                <td class="sign fail">Failed</td>
                <td class="version red">No Unicode support</td>
                <td class="instructions exclam"><a href="http://php.net/pcre" target="_blank">PCRE</a> has not been compiled with Unicode property support</td>
              <?php else: ?>
                <td class="sign pass">Pass</td>
                <td class="version"></td>
                <td class="instructions"></td>
              <?php endif ?>
            </tr>

            <tr>
              <th class="label">Mod Rewrite</th>
              <?php $have_module = apache_is_module_loaded('mod_rewrite'); ?>
              <?php if ($have_module): ?>
                <td class="sign pass">Pass</td>
                <td class="version"></td>
                <td class="instructions"></td>
              <?php elseif ($have_module == null): ?>
                <td class="sign gloups">Unknown</td>
                <td class="version">Unknown</td>
                <td class="instructions exclam">We could not determine if Mod Rewrite was enabled or not</td>
              <?php else: ?>
                <td class="sign fail">Failed</td>
                <td class="version red">Not enabled</td>
                <td class="instructions exclam">Ask your system administrator to enable Mod Rewrite for your site</td>
              <?php endif ?>
            </tr>

            <tr>
              <th class="label">cURL</th>
              <?php $have_curl = function_exists('curl_version') ? true : false; ?>
              <?php if ($have_curl): ?>
                <td class="sign pass">Pass</td>
                <td class="version"></td>
                <td class="instructions"></td>
              <?php else: ?>
                <td class="sign fail">Failed</td>
                <td class="version red">Not enabled</td>
                <td class="instructions exclam">Ask your system administrator to enable cURL for your site</td>
              <?php endif ?>
            </tr>

            <tr>
              <th class="label">GD Library</th>
              <?php $gd = gdversion(); ?>
              <?php if ($gd): ?>
                <td class="sign pass">Pass</td>
                <td class="version"></td>
                <td class="instructions"></td>
              <?php elseif ($gd == null): ?>
                <td class="sign gloups">Unknown</td>
                <td class="version">Unknown</td>
                <td class="instructions exclam">We could not determine if GD Library was enabled or not</td>
              <?php else: ?>
                <td class="sign fail">Missing</td>
                <td class="version red">Not enabled</td>
                <td class="instructions exclam">You will still be able to use Statmic, you just won't be able to use any image manipulation features.</td>
              <?php endif ?>
            </tr>

          </table>

        <div id="footer">
          <p class="faint" style="text-align:center">Powered by <a href="http://statamic.com">Statamic</a></p>
        </div>
      </div>
    </div>
    </div>

  </body>
</html>
<?php

  function gdversion() {
    $gd = gd_info();
    $ver = $gd['GD Version'];
    return $ver;
  }

  function apache_is_module_loaded($mod_name) {
    if (function_exists('apache_get_modules')) {
      $modules = apache_get_modules();
      return in_array($mod_name, $modules);
    } else {
      return null;
    }
  }

?>