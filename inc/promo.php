<?php
    $deadline = date('2016-10-01');
    $today = date('Y-m-d');
?>

<?php if($today < $deadline): ?>
<link href="http://fonts.googleapis.com/css?family=Robot:400&subset=latin,latin-ext" rel="stylesheet">
<style>
    .promo {
        position: fixed;
        bottom: 0;
        left: 5%;
        max-width: 0;
        max-height: 0;
        overflow: hidden;
        background: #2da02a url('<?php bloginfo('template_directory'); ?>/img/content/promo-bg.jpg') no-repeat center top;
        background-size: cover;
        box-shadow: rgba(0, 0, 0, 0.11765) 0px -1px 6px, rgba(0, 0, 0, 0.11765) 0px -1px 4px;
        transition: all .3s cubic-bezier(0.19, 1, 0.22, 1);
    }

    .promo--show {
        max-width: 600px;
        max-height: 1000px;
    }

    .promo--show .promo__inner {
        opacity: 1;
    }

    .promo__inner {
        position: relative;
        margin: 20px;
        padding: 30px;
        color: #fff;
        border: 1px solid;
        opacity: 0;
        text-shadow: 1px 1px 0 rgba(0, 0, 0, .2);
        transition: all .3s cubic-bezier(0.19, 1, 0.22, 1) .25s;
    }

    .promo__title {
        font-size: 2.4rem;
        text-align: center;
        margin-bottom: 1.5rem;
        white-space: nowrap;
    }

    .promo__title > span {
        display: inline-block;
        white-space: normal;
        vertical-align: middle;
    }

    .promo__title:before,
    .promo__title:after {
        content: '';
        width: 30px;
        height: 4px;
        background-color: #fff;
        display: inline-block;
        vertical-align: middle;
    }

    .promo__title:before {
        margin-right: 10px;
    }

    .promo__title:after {
        margin-left: 10px;
    }

    .promo__copy p {
        font-family: Roboto, Arial, Helvetica, sans-serif;
        font-size: 1.4rem;
        line-height: 1.3;
        margin-bottom: .8em;
    }

    .promo__copy a {
        color: #fff;
        border-bottom: 1px solid;
    }

    .promo__copy a:hover,
    .promo__copy a:focus {
        border-bottom: 0;
    }

    .promo .btn.btn--green {
        background-color: #353535;
        border-bottom-color: #2f2f2f;
    }

    .promo__subtitle {
        font-size: 1.8rem;
        margin-bottom: 0.6rem;
    }

    .promo__close {
        display: block;
        position: absolute;
        width: 40px;
        height: 40px;
        top: 1px;
        right: 1px;
        background: rgba(0, 0, 0, .2);
        border: 0;
        text-align: center;
    }

    @media only screen and (max-width: 620px) {
        .promo {
            left: 10px;
            right: 10px;
        }

        .promo__inner {
            margin: 10px;
            padding: 10px;
        }

        .promo__title {
            font-size: 1.6rem;
            margin-bottom: .6rem;
        }

        .promo__title:before,
        .promo__title:after {
            display: none;
        }

        .promo__subtitle {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }

        .promo__copy p {
            font-size: 1.2rem;
            margin-bottom: .6rem;
        }

        .promo .mb-20 {
            margin-bottom: 10px;
        }

    }

</style>

<article id="js-promo" class="promo z-heigh">
    <div class="promo__inner">
        <button type="button" class="promo__close" id="js-close-promo">
            <span class="icon close sprite"></span>
        </button>

        <h1 class="promo__title wf wf--roboto">
            <span>Új helyen, Új Időpontban!</span>
        </h1>
        <div class="promo__copy">
            <p>
                <strong>Felnőtt és gyerek edzések új helyszíne:</strong><br>
                <a href="https://www.facebook.com/CrossFit-Gemmeopolis-443177435883427/" target="_blank">Crossfit Gemmeopolis</a>, 3200 Gyöngyös Kenyérgyár u. 9
            </p>
            <p>
                <strong>Kempo Aerobik edzések új helyszíne:</strong><br>
                <a href="https://www.facebook.com/magicfitnessgyongyos/" target="_blank">Magic Fitness</a>, Móricz Zs. u. 4. I. emelet Gyöngyös
            </p>
        </div>
        <h2 class="promo__subtitle wf wf--roboto wf--roboto--light">
            Új időpontok:
        </h2>
        <div class="promo__copy mb-20">
            <p>
                <strong>Minden Kedden és Csütörtök</strong><br>
                Gyerek csoport 16:30 &ndash; 18:00<br>
                Felnőtt csoport 18:30 &ndash; 20:30
            </p>
        </div>
        <h1 class="promo__title wf wf--roboto">
            <span>Csatlakozz hozzánk!</span>
        </h1>
        <div class="promo__copy mb-20">
            <p>
            Várunk minden érdeklődőt 14 év alatt a gyerek és 15 év felett a felnőtt csoportba.
            </p>
        </div>

        <div class="txt txt--align-center">
            <h2 class="promo__subtitle wf wf--roboto wf--roboto--light">
                Érdeklődés emailben vagy telefonon:
            </h2>
            <div class="promo__copy">
                <p>
                    <a href="mailto:matrakempose@gmail.com?subject=Kempó edzés">
                        matrakempose@gmail.com
                    </a>
                </p>
                <p>06-20-965-28-74</p>
            </div>
        </div>
    </div>
</article>

<script>
var PROMO = (function () {
	var self = {},
		promoDiv,
        closeBtn,
        showClass = 'promo--show',
        waitTimeoutId = 0;

    function setCookie(cname, cvalue, exdays) {
        var d = new Date(),
            expires;

        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        expires = 'expires='+ d.toUTCString();
        document.cookie = cname + '=' + cvalue + '; ' + expires;
    }

    function getCookie(cname) {
        var name = cname + '=',
            ca = document.cookie.split(';');

        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length,c.length);
            }
        }

        return '';
    }

    function open() {
        if(!getCookie('hasSeenPromo')) {
            promoDiv.className += ' ' + showClass;
        }
    }

    function close() {
        promoDiv.className = 'promo';
        setCookie('hasSeenPromo', '1', 90);
    }

	function getElements() {
		promoDiv = document.getElementById('js-promo');
        closeBtn = document.getElementById('js-close-promo');
	}

    function addEvents() {
        closeBtn.addEventListener('click', close, false);
    }

	self.init = function () {
		getElements();
        addEvents();

        waitTimeoutId = window.clearTimeout(waitTimeoutId);

        waitTimeoutId = window.setTimeout(open, 3000);
	};

	return self;
}());

PROMO.init();
</script>

<?php endif;?>
