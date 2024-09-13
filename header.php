<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<base href="<?php echo home_url(); ?>">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
  <script>
    history.scrollRestoration = "manual";
  </script>
</head>

<body <?php
if (is_front_page()) {
    body_class('menu-open');
} elseif (is_page('artigos')) {
    body_class('menu-open white');
} else {
    body_class('menu-open');
}
?>>

    <div class="global">
      <div class="menu">
        <div class="menu_icon_wrap">
          <?php 
            $black_class = is_page('artigos') ? ' black' : ''; 
          ?>
          <div style="opacity:1" class="open">
            <div class="burguerline<?php echo $black_class; ?>"></div>
            <div class="burguerline margin<?php echo $black_class; ?>"></div>
            <div class="burguerline<?php echo $black_class; ?>"></div>
          </div>
          <div style="opacity:0" class="close">
            <div class="burguerline positive<?php echo $black_class; ?>"></div>
            <div class="burguerline negative<?php echo $black_class; ?>"></div>
          </div>
        </div>
        <div class="noverflow">
          <div class="menu_text_wrap">


          <?php
            $current_language = get_locale();
            $current_url = get_permalink();

            $pt_url = preg_replace('~(/en/|/en$)~', '/', $current_url);
            $en_url = (strpos($current_url, '/en') === false) ? home_url('/en' . parse_url($current_url, PHP_URL_PATH)) : $current_url;

            $pt_url = rtrim($pt_url, '/') . '/';
            $en_url = rtrim(preg_replace('~/en/en(/|$)~', '/en/', $en_url), '/') . '/';

            $is_english = ($current_language === 'en_US');
            ?>


            <a href="<?php echo esc_url($pt_url); ?>" class="w-inline-block">
                <div class="language<?php echo $black_class; ?><?php echo (!$is_english) ? ' current-language' : ''; ?>">
                    PT
                </div>
            </a>
            <div class="language<?php echo $black_class; ?>">/</div>
            <a href="<?php echo esc_url($en_url); ?>" class="w-inline-block">
                <div class="language<?php echo $black_class; ?><?php echo ($is_english) ? ' current-language' : ''; ?>">
                    EN
                </div>
            </a>

          </div>
        </div>
      </div>
      <div id="intro_wrap" class="intro_wrap">
        <div class="div-block-11"><img src="<?php echo get_template_directory_uri() ?>/assets/images/Group-299.svg" loading="lazy" alt=" Logotipo da Conbarra Consultoria." class="intro_logo"></div>
      </div>
      <div style="opacity:0;display:none" class="nav">
        <div class="w-layout-grid menugrid">
          <div class="menutop">
            <div class="div-block-12"><svg xmlns="http://www.w3.org/2000/svg" width="100%" viewbox="0 0 520 101" fill="none" class="logo-menu">
                <path d="M166.97 99.2813C165.424 98.4535 164.209 97.2946 163.325 95.8323C162.442 94.3699 162 92.7144 162 90.8657C162 89.017 162.442 87.3615 163.325 85.8991C164.209 84.4368 165.424 83.2779 166.97 82.4501C168.517 81.6224 170.229 81.2085 172.162 81.2085C173.791 81.2085 175.255 81.4844 176.552 82.0638C177.85 82.6433 178.955 83.4434 179.839 84.5195L177.05 87.0856C175.779 85.6232 174.233 84.9058 172.355 84.9058C171.195 84.9058 170.174 85.1541 169.262 85.6784C168.351 86.175 167.661 86.8924 167.136 87.803C166.639 88.7135 166.363 89.7344 166.363 90.8933C166.363 92.0521 166.612 93.0731 167.136 93.9836C167.633 94.8941 168.351 95.5839 169.262 96.1082C170.174 96.6048 171.195 96.8807 172.355 96.8807C174.233 96.8807 175.779 96.1358 177.05 94.6734L179.839 97.2394C178.955 98.3155 177.85 99.1433 176.525 99.7227C175.199 100.302 173.736 100.578 172.134 100.578C170.229 100.578 168.517 100.164 166.97 99.3365V99.2813Z" fill="currentColor" class="path-7"></path>
                <path d="M201.654 99.2531C200.108 98.4254 198.865 97.2665 197.982 95.8041C197.098 94.3418 196.656 92.6863 196.656 90.8652C196.656 89.0441 197.098 87.3886 197.982 85.9262C198.865 84.4639 200.08 83.305 201.654 82.4772C203.201 81.6495 204.968 81.2356 206.901 81.2356C208.834 81.2356 210.574 81.6495 212.148 82.4772C213.694 83.305 214.909 84.4639 215.793 85.9262C216.676 87.3886 217.118 89.0441 217.118 90.8652C217.118 92.6863 216.676 94.3418 215.793 95.8041C214.909 97.2665 213.694 98.4254 212.148 99.2531C210.601 100.081 208.862 100.495 206.901 100.495C204.94 100.495 203.201 100.081 201.654 99.2531ZM209.883 96.0801C210.767 95.5834 211.485 94.866 211.982 93.9555C212.479 93.045 212.755 92.0241 212.755 90.8652C212.755 89.7063 212.507 88.6854 211.982 87.7749C211.485 86.8644 210.767 86.1746 209.883 85.6503C209 85.1261 208.006 84.8777 206.901 84.8777C205.796 84.8777 204.802 85.1261 203.919 85.6503C203.035 86.1746 202.317 86.8644 201.82 87.7749C201.323 88.6854 201.047 89.7063 201.047 90.8652C201.047 92.0241 201.295 93.045 201.82 93.9555C202.317 94.866 203.035 95.5558 203.919 96.0801C204.802 96.5767 205.796 96.8527 206.901 96.8527C208.006 96.8527 209 96.6043 209.883 96.0801Z" fill="currentColor" class="path-6"></path>
                <path d="M253.015 81.5115V100.191H249.453L240.147 88.851V100.191H235.867V81.5115H239.457L248.735 92.8518V81.5115H253.015Z" fill="currentColor" class="path-5"></path>
                <path d="M274.775 99.9154C273.394 99.5015 272.289 99.0049 271.461 98.3427L272.924 95.0868C273.725 95.6662 274.664 96.1353 275.769 96.494C276.873 96.8527 277.978 97.0182 279.082 97.0182C280.297 97.0182 281.209 96.8251 281.816 96.4664C282.396 96.1077 282.7 95.611 282.7 95.004C282.7 94.5625 282.534 94.2039 282.175 93.9003C281.844 93.5968 281.374 93.3761 280.85 93.1829C280.297 93.0174 279.579 92.7967 278.641 92.6035C277.205 92.2724 276.045 91.9413 275.134 91.5826C274.222 91.2515 273.449 90.6997 272.786 89.9547C272.124 89.2097 271.82 88.2164 271.82 86.9747C271.82 85.8986 272.124 84.9053 272.704 84.0224C273.283 83.1395 274.167 82.4497 275.354 81.9254C276.542 81.4012 277.978 81.1528 279.69 81.1528C280.877 81.1528 282.037 81.2908 283.197 81.5667C284.329 81.8426 285.323 82.2565 286.179 82.7808L284.854 86.0642C283.142 85.0985 281.402 84.6018 279.662 84.6018C278.447 84.6018 277.564 84.795 276.984 85.1813C276.404 85.5676 276.128 86.0918 276.128 86.7264C276.128 87.361 276.459 87.8301 277.122 88.1612C277.785 88.4647 278.806 88.7682 280.187 89.0717C281.623 89.4028 282.783 89.7615 283.694 90.0926C284.605 90.4237 285.378 90.9756 286.041 91.693C286.704 92.4104 287.008 93.4037 287.008 94.6453C287.008 95.7214 286.704 96.6871 286.124 97.57C285.516 98.453 284.633 99.1428 283.445 99.6671C282.258 100.191 280.794 100.44 279.082 100.44C277.591 100.44 276.183 100.246 274.802 99.8326L274.775 99.9154Z" fill="currentColor" class="path-8"></path>
                <path d="M307.524 98.2874C306.033 96.7974 305.287 94.7004 305.287 91.9688V81.5115H309.622V91.8033C309.622 95.1419 311.003 96.825 313.792 96.825C315.145 96.825 316.167 96.4112 316.885 95.611C317.603 94.8108 317.962 93.5416 317.962 91.8033V81.5115H322.242V91.9688C322.242 94.7004 321.496 96.825 320.005 98.2874C318.514 99.7498 316.443 100.495 313.765 100.495C311.086 100.495 309.015 99.7498 307.524 98.2874Z" fill="currentColor" class="path-9"></path>
                <path d="M341.959 81.5115H346.294V96.6595H355.655V100.191H341.959V81.5115Z" fill="currentColor" class="path-10"></path>
                <path d="M375.705 85.0432H369.713V81.5115H386.005V85.0432H380.013V100.191H375.677V85.0432H375.705Z" fill="currentColor" class="path-4"></path>
                <path d="M407.377 99.2531C405.831 98.4254 404.588 97.2665 403.704 95.8041C402.821 94.3418 402.379 92.6863 402.379 90.8652C402.379 89.0441 402.821 87.3886 403.704 85.9262C404.588 84.4639 405.803 83.305 407.377 82.4772C408.923 81.6495 410.691 81.2356 412.624 81.2356C414.557 81.2356 416.296 81.6495 417.87 82.4772C419.417 83.305 420.632 84.4639 421.515 85.9262C422.399 87.3886 422.841 89.0441 422.841 90.8652C422.841 92.6863 422.399 94.3418 421.515 95.8041C420.632 97.2665 419.417 98.4254 417.87 99.2531C416.324 100.081 414.584 100.495 412.624 100.495C410.663 100.495 408.923 100.081 407.377 99.2531ZM415.606 96.0801C416.49 95.5834 417.208 94.866 417.705 93.9555C418.202 93.045 418.478 92.0241 418.478 90.8652C418.478 89.7063 418.229 88.6854 417.705 87.7749C417.208 86.8644 416.49 86.1746 415.606 85.6503C414.722 85.1261 413.728 84.8777 412.624 84.8777C411.519 84.8777 410.525 85.1261 409.641 85.6503C408.758 86.1746 408.04 86.8644 407.543 87.7749C407.046 88.6854 406.769 89.7063 406.769 90.8652C406.769 92.0241 407.018 93.045 407.543 93.9555C408.04 94.866 408.758 95.5558 409.641 96.0801C410.525 96.5767 411.519 96.8527 412.624 96.8527C413.728 96.8527 414.722 96.6043 415.606 96.0801Z" fill="currentColor" class="path-11"></path>
                <path d="M453.492 100.191L449.874 94.9764H445.898V100.191H441.562V81.5115H449.653C451.31 81.5115 452.746 81.7874 453.961 82.3392C455.176 82.8911 456.115 83.6636 456.778 84.6845C457.44 85.7054 457.772 86.8919 457.772 88.2991C457.772 89.7063 457.44 90.8927 456.778 91.8861C456.115 92.8794 455.176 93.652 453.933 94.2038L458.131 100.219H453.492V100.191ZM452.387 85.871C451.697 85.3192 450.73 85.0432 449.432 85.0432H445.898V91.555H449.432C450.73 91.555 451.724 91.279 452.387 90.6996C453.05 90.1202 453.409 89.32 453.409 88.2991C453.409 87.2782 453.077 86.4504 452.387 85.871Z" fill="currentColor" class="path-12"></path>
                <path d="M476.686 81.5115H481.021V100.191H476.686V81.5115Z" fill="currentColor" class="path-13"></path>
                <path d="M513.248 96.1904H504.577L502.92 100.191H498.502L506.841 81.5115H511.121L519.488 100.191H514.96L513.303 96.1904H513.248ZM511.867 92.907L508.912 85.7606L505.958 92.907H511.895H511.867Z" fill="currentColor" class="path-14"></path>
                <path d="M166.687 42.95L133.268 17.0605V62.4869H143.68V36.6694L177.099 62.5589V17.1324H166.687V42.95ZM14.8982 29.5498C16.6496 28.2074 18.6408 27.1526 20.8959 26.4095C23.151 25.6664 25.4781 25.3068 27.9252 25.3068C30.3722 25.3068 32.9152 25.6664 35.4103 26.4095C37.9293 27.1526 40.0165 28.2074 41.7198 29.5498L41.7918 29.6217L49.109 23.7966H49.037C46.374 21.6631 43.3032 20.009 39.8246 18.8584C36.3459 17.7077 32.6514 17.1324 28.7649 17.1324C24.8784 17.1324 21.2078 17.7077 17.7051 18.8584C14.2025 20.009 11.1317 21.6631 8.49271 23.7966C5.73378 25.8821 3.64659 28.3272 2.18315 31.084C0.719721 33.8407 0 36.7413 0 39.7378C0 42.7342 0.719721 45.7547 2.18315 48.4875C3.64659 51.2442 5.75777 53.6654 8.49271 55.7988C11.1557 57.9323 14.2265 59.5864 17.7051 60.737C21.1838 61.8877 24.8784 62.463 28.7649 62.463C32.6514 62.463 36.3219 61.8877 39.8246 60.737C43.3032 59.5864 46.398 57.9323 49.037 55.7988H49.109L41.7918 49.9737H41.7198C39.9205 51.3641 37.8573 52.4188 35.5302 53.138C33.2031 53.8571 30.7801 54.2167 28.309 54.2167C25.838 54.2167 23.4149 53.8571 21.0878 53.138C18.7607 52.4188 16.6975 51.3641 14.8982 49.9737C13.1469 48.5833 11.8274 47.0012 10.9158 45.2752C10.0041 43.5493 9.5483 41.6795 9.5483 39.7138C9.5483 37.7481 10.0041 35.9502 10.9158 34.2003C11.8274 32.4264 13.1709 30.8682 14.8982 29.5258V29.5498ZM110.117 23.7966C107.454 21.6631 104.384 20.009 100.881 18.8584C97.4023 17.7077 93.7077 17.1324 89.8212 17.1324C85.9347 17.1324 82.2641 17.7077 78.7615 18.8584C75.2828 20.009 72.188 21.6631 69.5491 23.7966C66.7901 25.8821 64.7029 28.3272 63.2395 31.084C61.7761 33.8407 61.0563 36.7413 61.0563 39.7378C61.0563 42.7342 61.7761 45.7547 63.2395 48.4875C64.7029 51.2442 66.8141 53.6654 69.5491 55.7988C72.212 57.9323 75.2828 59.5864 78.7615 60.737C82.2401 61.8877 85.9347 62.463 89.8212 62.463C93.7077 62.463 97.3783 61.8877 100.881 60.737C104.36 59.5864 107.454 57.9323 110.117 55.7988C112.876 53.6654 114.963 51.2202 116.427 48.4395C117.89 45.6588 118.61 42.7582 118.61 39.7138C118.61 36.6694 117.89 33.8407 116.427 31.084C114.963 28.3272 112.852 25.9061 110.117 23.7726V23.7966ZM105.679 47.0731C104.048 49.3025 101.817 51.0524 99.0096 52.3709C96.2027 53.6893 93.1319 54.3366 89.8212 54.3366C86.5105 54.3366 83.4397 53.6893 80.6328 52.3709C77.8258 51.0524 75.5947 49.3025 73.9154 47.0731C72.26 44.8437 71.4203 42.3986 71.4203 39.7617C71.4203 37.1249 72.236 34.7277 73.9154 32.4983C75.5707 30.2689 77.8019 28.519 80.6328 27.2245C83.4397 25.93 86.5105 25.3068 89.8212 25.3068C93.1319 25.3068 96.2027 25.954 99.0096 27.2245C101.817 28.519 104.048 30.2689 105.679 32.4983C107.31 34.7277 108.126 37.1488 108.126 39.7617C108.126 42.3747 107.31 44.8677 105.679 47.0731ZM489.338 8.57451L477.847 29.406C481.062 31.875 484.108 34.464 487.011 37.1488L489.338 32.738L496.488 46.1862L500.926 54.7201L505.124 62.5589L519.039 62.3911L489.338 8.55054V8.57451ZM436.463 41.5356C438.118 39.1145 438.958 36.5016 438.958 33.6489C438.958 30.6525 437.998 27.8718 436.103 25.3547C434.208 22.8377 431.641 20.8241 428.426 19.3378C425.211 17.8516 421.661 17.1084 417.822 17.1084H395.127V62.463H405.539V50.3093H417.846C418.542 50.3093 419.501 50.2614 420.725 50.1894C421.781 52.8503 423.196 55.0797 424.971 56.8536C428.282 60.1617 432.504 62.0075 437.59 62.415V53.3297C435.311 52.8024 433.392 51.7476 431.761 50.1175C431.185 49.5422 430.513 48.6553 429.721 47.4327C432.552 45.8985 434.808 43.9328 436.463 41.5117V41.5356ZM427.107 37.892C426.147 39.1864 424.851 40.1932 423.22 40.9603C421.589 41.7274 419.789 42.111 417.822 42.111H405.515V25.3068H417.822C419.789 25.3068 421.589 25.6903 423.22 26.4574C424.851 27.2245 426.147 28.2553 427.107 29.5258C428.066 30.8203 428.546 32.1867 428.546 33.6729C428.546 35.1592 428.066 36.5975 427.107 37.892ZM238.612 35.5667C239.475 34.0085 239.883 32.3305 239.883 30.5326C239.883 28.0875 239.115 25.8581 237.604 23.7966C236.069 21.759 234.005 20.1289 231.39 18.9303C228.775 17.7317 225.944 17.1324 222.898 17.1324H196.076V62.4869H222.898C225.944 62.4869 228.775 61.8876 231.39 60.6891C234.005 59.4905 236.069 57.8604 237.604 55.8228C239.139 53.7852 239.883 51.5319 239.883 49.0867C239.883 47.3128 239.451 45.6348 238.612 44.0527C237.772 42.4945 236.596 41.0562 235.109 39.7378C236.596 38.5152 237.748 37.1248 238.612 35.5427V35.5667ZM227.504 52.7544C226.184 53.8092 224.649 54.3126 222.85 54.3126H206.44V43.9088H223.186C224.889 43.9088 226.352 44.4123 227.6 45.4431C228.847 46.4738 229.471 47.6724 229.471 49.0628C229.471 50.4531 228.823 51.6757 227.504 52.7304V52.7544ZM227.6 34.0565C226.352 35.0633 224.889 35.6146 223.186 35.6865H206.44V25.2828H222.85C224.625 25.2828 226.184 25.8102 227.504 26.841C228.823 27.8957 229.471 29.1183 229.471 30.5087C229.471 31.899 228.847 33.0257 227.6 34.0325V34.0565ZM371.472 41.5356C373.127 39.1145 373.967 36.5016 373.967 33.6489C373.967 30.6525 373.007 27.8718 371.112 25.3547C369.217 22.8377 366.65 20.8241 363.435 19.3378C360.22 17.8516 356.67 17.1084 352.831 17.1084H331.815C331.24 17.4201 330.712 17.7557 330.136 18.0673V62.4869H340.548V50.3333H352.855C353.551 50.3333 354.511 50.2853 355.734 50.2134C356.79 52.8743 358.205 55.1037 359.981 56.8776C363.291 60.1857 367.514 62.0315 372.6 62.439V53.3537C370.321 52.8263 368.401 51.7716 366.77 50.1415C366.194 49.5662 365.522 48.6792 364.731 47.4567C367.562 45.9225 369.817 43.9568 371.472 41.5356ZM362.116 37.892C361.156 39.1864 359.861 40.1932 358.229 40.9603C356.598 41.7274 354.799 42.111 352.831 42.111H340.524V25.3068H352.831C354.799 25.3068 356.598 25.6903 358.229 26.4574C359.861 27.2245 361.156 28.2553 362.116 29.5258C363.075 30.8203 363.555 32.1867 363.555 33.6729C363.555 35.1592 363.075 36.5975 362.116 37.892ZM459.638 62.415L473.624 62.5828V62.5109L477.823 54.6722L480.582 49.3744C477.151 47.7204 473.385 46.1862 469.33 44.8438L459.614 62.439L459.638 62.415ZM282.131 8.57451L252.43 62.415L266.417 62.5828V62.5109L270.615 54.6722L275.197 45.8985L282.107 32.762L284.434 37.1249C287.337 34.44 290.383 31.8511 293.574 29.382L282.107 8.59849L282.131 8.57451ZM290.911 49.2785L293.718 54.6961L297.917 62.5349L311.831 62.3671L302.091 44.7239C298.061 46.0663 294.318 47.6245 290.887 49.2545L290.911 49.2785Z" fill="currentColor" class="path-2"></path>
                <path d="M316.558 17.5876C295.638 28.4947 277.885 43.8846 266.369 62.4627C266.369 62.4627 281.075 48.5111 304.13 41.6072L304.178 41.5593C312.047 20.9916 341.388 5.09829 377.974 2.07786C379.245 1.98197 382.46 1.91006 385.747 1.93403C389.034 1.958 392.416 2.00595 393.736 2.10183C430.226 5.17022 459.47 21.0395 467.315 41.5593L467.363 41.6072C490.418 48.5351 505.125 62.4627 505.125 62.4627C493.609 43.9085 475.856 28.5187 454.936 17.5876C411.753 -4.94586 359.789 -4.94586 316.606 17.5876H316.558Z" fill="currentColor" class="path-3"></path>
              </svg>
              <div class="socialicons">
                <div class="w-layout-grid socialiconsgrid">
                  <a style="color:rgb(200,200,200)" href="https://www.linkedin.com/company/conbarra/" target="_blank" class="menusocialiconwrap w-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="100%" viewbox="0 0 21 21" fill="none" class="socialicon">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M2.66606e-07 1.75446C2.66606e-07 1.28916 0.184842 0.842896 0.513868 0.51387C0.842894 0.184844 1.28914 2.39512e-06 1.75446 2.39512e-06H19.2436C19.4742 -0.000378781 19.7026 0.0447411 19.9158 0.13275C20.1289 0.22076 20.3226 0.34995 20.4857 0.51291C20.6489 0.675884 20.7782 0.869423 20.8666 1.08247C20.9548 1.29551 21.0001 1.52386 21 1.75446V19.2436C21.0003 19.4743 20.955 19.7027 20.8669 19.9159C20.7788 20.1289 20.6495 20.3226 20.4864 20.4858C20.3235 20.6489 20.1298 20.7784 19.9168 20.8666C19.7036 20.9548 19.4753 21.0001 19.2446 21H1.75446C1.52397 21 1.29576 20.9545 1.08284 20.8663C0.869916 20.7781 0.676461 20.6488 0.51353 20.4858C0.350598 20.3228 0.221393 20.1292 0.133271 19.9163C0.0451625 19.7033 -0.000126792 19.475 2.66606e-07 19.2446V1.75446ZM8.31219 8.00668H11.1558V9.43468C11.5662 8.61388 12.6162 7.87497 14.194 7.87497C17.219 7.87497 17.9359 9.51007 17.9359 12.5102V18.0676H14.8746V13.1938C14.8746 11.4851 14.4642 10.521 13.4219 10.521C11.9757 10.521 11.3743 11.5605 11.3743 13.1938V18.0676H8.31219V8.00668ZM3.06219 17.9369H6.12436V7.87497H3.06219V17.9369ZM6.5625 4.59328C6.56828 4.85547 6.52162 5.11617 6.42528 5.36008C6.32893 5.60399 6.18483 5.8262 6.00145 6.01367C5.81807 6.20114 5.59907 6.35009 5.35734 6.45178C5.11561 6.55347 4.856 6.60586 4.59376 6.60586C4.33151 6.60586 4.07188 6.55347 3.83016 6.45178C3.58842 6.35009 3.36945 6.20114 3.18606 6.01367C3.00267 5.8262 2.85857 5.60399 2.76223 5.36008C2.66588 5.11617 2.61923 4.85547 2.62501 4.59328C2.63633 4.07863 2.84873 3.58889 3.21671 3.22893C3.58468 2.86896 4.07898 2.6674 4.59376 2.6674C5.10851 2.6674 5.60281 2.86896 5.97079 3.22893C6.33877 3.58889 6.55117 4.07863 6.5625 4.59328Z" fill="currentColor"></path>
                    </svg></a>
                  <a style="color:rgb(200,200,200)" href="mailto:contato@conbarra.com.br?subject=mais%20informa%C3%A7%C3%B5es%20sobre%20a%20CONBARRA" class="menusocialiconwrap w-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="100%" viewbox="0 0 24 21" fill="none" class="socialicon">
                      <path d="M2 0C1.29559 0 0.680324 0.380953 0.324219 0.955664L11.293 12.4729C11.6969 12.897 12.3031 12.897 12.707 12.4729L23.6758 0.955664C23.3197 0.380953 22.7044 0 22 0H2ZM0 3.58477V18.9C0 20.0634 0.892 21 2 21H22C23.108 21 24 20.0634 24 18.9V3.58477L14.1211 13.9576C12.9581 15.1788 11.0419 15.1788 9.87891 13.9576L0 3.58477Z" fill="currentColor"></path>
                    </svg></a>
                  <a style="color:rgb(200,200,200)" href="https://wa.me/5561999964495" target="_blank" class="menusocialiconwrap w-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="100%" viewbox="0 0 57 58" fill="none" class="socialicon">
                      <path d="M28.5 0.5C13.3266 0.5 0 13.8266 0 29C0 33.8772 1.33929 38.4288 3.57 42.4021L1.04437 55.98C0.988072 56.1813 0.985529 56.3974 1.03699 56.6C1.08846 56.8026 1.19213 56.99 1.33768 57.14C1.48322 57.29 1.66556 57.3924 1.8665 57.45C2.06744 57.5076 2.27996 57.5102 2.48289 57.46L15.6 54.21C19.4544 56.2677 23.8281 57.5 28.5 57.5C43.6734 57.5 57 44.1734 57 29C57 13.8266 43.6734 0.5 28.5 0.5ZM28.5 3.8913C42.381 3.8913 53.6087 15.119 53.6087 29C53.6087 42.881 42.381 54.1087 28.5 54.1087C24.0498 54.1087 19.8819 52.9485 16.2586 50.9211C15.9936 50.773 15.6822 50.7313 15.3875 50.8043L3.90039 53.651L6.9806 42.6613C7.02467 42.506 7.03684 42.3433 7.01637 42.1832C6.9959 42.0231 6.94322 41.8687 6.8615 41.7295C4.65952 37.9956 3.3913 33.6512 3.3913 29C3.3913 15.119 14.619 3.8913 28.5 3.8913ZM18.5074 14.6522C17.741 14.6522 16.6464 14.9373 15.7472 15.9062C15.2071 16.4882 12.9565 18.6809 12.9565 22.536C12.9565 26.5552 15.7441 30.0233 16.0811 30.4689L16.0834 30.4712C16.0515 30.4292 16.5112 31.095 17.125 31.8934C17.7387 32.6918 18.5969 33.7403 19.6751 34.8755C21.8314 37.1459 24.8632 39.7697 28.6261 41.3745C30.359 42.1125 31.7261 42.558 32.7618 42.8831C34.6813 43.4858 36.4297 43.3942 37.743 43.2007C38.726 43.0559 39.8071 42.5839 40.8769 41.907C41.9466 41.23 42.995 40.3883 43.4573 39.1093C43.7885 38.1925 43.9569 37.3452 44.0178 36.648C44.0482 36.2994 44.0521 35.9917 44.0295 35.7069C44.0068 35.422 44.031 35.2038 43.7656 34.7681C43.2089 33.8541 42.5785 33.8303 41.9207 33.5047C41.5553 33.3238 40.5147 32.8157 39.471 32.3184C38.4286 31.8216 37.5259 31.3817 36.97 31.1835C36.6188 31.0571 36.1899 30.8752 35.5712 30.9453C34.9524 31.0153 34.3413 31.4618 33.9855 31.9891C33.6483 32.489 32.2907 34.0915 31.8768 34.5626C31.8713 34.5592 31.9072 34.5758 31.7437 34.4949C31.2318 34.2415 30.6057 34.0261 29.6793 33.5374C28.7529 33.0487 27.594 32.3271 26.3259 31.2092C24.4384 29.5475 23.1163 27.4589 22.6992 26.7582C22.7273 26.7247 22.6959 26.7652 22.7553 26.7068L22.7576 26.7044C23.1839 26.2846 23.5616 25.7831 23.8809 25.4154C24.3335 24.894 24.5332 24.4343 24.7496 24.0049C25.1808 23.149 24.9407 22.2072 24.6912 21.7117C24.7084 21.7459 24.5562 21.4078 24.3923 21.0204C24.2279 20.6319 24.0183 20.1283 23.7945 19.5912C23.3468 18.5171 22.847 17.3124 22.5498 16.6068C22.1996 15.7757 21.7259 15.1746 21.1066 14.8857C20.4872 14.5968 19.9401 14.679 19.9179 14.6779C19.476 14.6575 18.9886 14.6522 18.5074 14.6522Z" fill="currentColor"></path>
                    </svg></a>
                </div>
              </div>
            </div>
          </div>
          <div class="menubottom">
            <div class="navlinkwraper">
              <a href="<?php echo get_home_url(); ?>/artigos" class="navlink _1 w-inline-block">
                <div class="navlinktext _1">Blog</div>
              </a>
              <a href="<?php echo get_home_url(); ?>" class="navlink _2 w-inline-block">
                <div class="navlinktext _2">Home</div>
              </a>
              <a href="https://wa.me/5561999964495" class="navlink _3 w-inline-block">
                <div class="navlinktext _3">Contato</div>
              </a>
            </div>
            <div class="navimages">
              <div class="navimgwrap _1">
                <div class="navimgoffset _1"></div><img src="<?php echo get_template_directory_uri() ?>/assets/images/Frame-12.png" loading="lazy" alt=" Imagem de uma câmera fotográfica retrô com um arco-íris saindo da lente." class="navimg">
              </div>
              <div class="navimgwrap _2">
                <div class="navimgoffset _2"></div><img src="<?php echo get_template_directory_uri() ?>/assets/images/Group-304.svg" loading="lazy" alt=" Logotipo da Conbarra Consultoria." class="navimg2">
              </div>
              <div class="navimgwrap _3">
                <div class="navimgoffset _3"></div><img src="<?php echo get_template_directory_uri() ?>/assets/images/25f07722b98b2a205ab37b4b67d57c06ea0b795ee73e1a0ec4f163054a33953c-1.png" loading="lazy" alt="Imagem de um telefone vermelho antigo." class="navimg3">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



