<?php
namespace App\View\Helper;

use App\Core\Setting;
use Cake\I18n\I18n;
use Cake\View\Helper;

/**
 * Recaptcha helper
 */
class RecaptchaHelper extends Helper
{
    /**
     * Display recaptcha function
     * @return string|bool
     */
    public function display()
    {
        if (!Setting::readOrFail('Recaptcha.enable')) {
            return false;
        }
        $sitekey = Setting::readOrFail('Recaptcha.sitekey');
        $lang = Setting::readOrFail('Recaptcha.lang');
        $theme = Setting::readOrFail('Recaptcha.theme');
        $type = Setting::readOrFail('Recaptcha.type');

        return <<<EOF
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=$lang" async defer></script>
<div class="g-recaptcha" data-sitekey="$sitekey" data-theme="$theme" data-type="$type"></div>
<noscript>
  <div>
    <div style="width: 302px; height: 422px; position: relative;">
      <div style="width: 302px; height: 422px; position: absolute;">
        <iframe src="https://www.google.com/recaptcha/api/fallback?k=$sitekey"
                frameborder="0" scrolling="no"
                style="width: 302px; height:422px; border-style: none;">
        </iframe>
      </div>
    </div>
    <div style="width: 300px; height: 60px; border-style: none;
                   bottom: 12px; left: 25px; margin: 0px; padding: 0px; right: 25px;
                   background: #f9f9f9; border: 1px solid #c1c1c1; border-radius: 3px;">
      <textarea id="g-recaptcha-response" name="g-recaptcha-response"
                   class="g-recaptcha-response"
                   style="width: 250px; height: 40px; border: 1px solid #c1c1c1;
                          margin: 10px 25px; padding: 0px; resize: none;" >
      </textarea>
    </div>
  </div>
</noscript>
EOF;
    }
}
