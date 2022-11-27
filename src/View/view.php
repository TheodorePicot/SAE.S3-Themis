<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <!-- css -->
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">

</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light fs-5">
        <div class="container-fluid">
            <a class="navbar-brand" id="icon" href="frontController.php">
                <svg width="60" height="60" viewBox="0 0 83 83" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_54_125)">
                        <path d="M24.64 63.45L24.12 65.28L23.89 65.2C23.9471 64.9578 23.964 64.7078 23.94 64.46C23.8982 64.215 23.7831 63.9883 23.61 63.81C23.3972 63.6029 23.141 63.4457 22.86 63.35L21.74 62.91C20.8 65.21 20.33 66.35 19.4 68.65C19.238 68.9312 19.1779 69.2597 19.23 69.58C19.3842 69.8463 19.6348 70.0432 19.93 70.13L20.25 70.25L20.17 70.46C18.6 69.86 17.82 69.54 16.29 68.82L16.38 68.62L16.7 68.77C16.8412 68.8516 16.9986 68.901 17.1611 68.9149C17.3235 68.9287 17.487 68.9065 17.64 68.85C17.79 68.78 17.95 68.53 18.14 68.11L20.61 62.44L19.66 62.01C19.4049 61.8759 19.1322 61.7783 18.85 61.72C18.6046 61.6944 18.3573 61.7432 18.14 61.86C17.8671 62.012 17.642 62.2371 17.49 62.51L17.27 62.4L18.27 60.75C20.3139 61.8269 22.4447 62.7301 24.64 63.45Z"
                              fill="#231F20"/>
                        <path d="M26.51 67.97C28.14 68.41 28.97 68.6 30.62 68.91L31.05 66.63C31.1142 66.3617 31.1378 66.0853 31.12 65.81C31.0863 65.6889 31.0122 65.5831 30.91 65.51C30.7572 65.3834 30.5749 65.2975 30.38 65.26L30.09 65.2V64.98C31.49 65.28 32.2 65.41 33.62 65.6V65.82H33.33C33.1393 65.7745 32.9407 65.7745 32.75 65.82C32.6167 65.8621 32.503 65.9508 32.43 66.07C32.3273 66.3159 32.2599 66.5752 32.23 66.84C31.89 68.9 31.73 69.93 31.39 72C31.3384 72.2675 31.3384 72.5425 31.39 72.81C31.433 72.9377 31.5222 73.0447 31.64 73.11C31.8279 73.2391 32.0439 73.3213 32.27 73.35L32.61 73.4V73.62C30.95 73.39 30.13 73.25 28.49 72.9V72.68L28.83 72.75C28.9815 72.796 29.141 72.8091 29.298 72.7885C29.4549 72.7678 29.6056 72.7137 29.74 72.63C29.9473 72.3852 30.07 72.0801 30.09 71.76L30.55 69.34C28.88 69.02 28.05 68.83 26.41 68.34L25.76 70.73C25.6662 70.9892 25.6254 71.2647 25.64 71.54C25.6758 71.6681 25.7532 71.7807 25.86 71.86C26.0332 72.0065 26.2389 72.1093 26.46 72.16L26.8 72.25V72.46C25.17 72.06 24.36 71.83 22.75 71.31L22.82 71.1L23.15 71.2C23.2963 71.2654 23.4547 71.2991 23.615 71.2991C23.7752 71.2991 23.9337 71.2654 24.08 71.2C24.303 70.9698 24.4496 70.6765 24.5 70.36L26 65.36C26.0952 65.1 26.1491 64.8267 26.16 64.55C26.1384 64.4259 26.0749 64.3129 25.98 64.23C25.8379 64.0914 25.6673 63.9856 25.48 63.92L25.19 63.83L25.26 63.62C26.64 64.07 27.33 64.27 28.74 64.62L28.68 64.83L28.39 64.76C28.1959 64.7151 27.9941 64.7151 27.8 64.76C27.7335 64.7705 27.6699 64.7945 27.6131 64.8306C27.5564 64.8668 27.5076 64.9142 27.47 64.97C27.3345 65.1997 27.2366 65.4495 27.18 65.71L26.51 67.97Z"
                              fill="#231F20"/>
                        <path d="M36.57 66.36C36.46 67.64 36.41 68.27 36.31 69.55C37.1 69.61 37.5 69.64 38.31 69.67C38.6528 69.7115 39.0002 69.6525 39.31 69.5C39.4441 69.3719 39.5485 69.216 39.6159 69.0432C39.6832 68.8705 39.712 68.685 39.7 68.5H39.94V71.32H39.69C39.6691 71.059 39.6084 70.8027 39.51 70.56C39.4238 70.4083 39.2904 70.2889 39.13 70.22C38.8608 70.123 38.5762 70.0756 38.29 70.08C37.49 70.08 37.09 70.02 36.29 69.96C36.2 71.02 36.16 71.56 36.08 72.62C36.0467 72.8387 36.0467 73.0613 36.08 73.28C36.1209 73.3649 36.1873 73.4348 36.27 73.48C36.4379 73.5494 36.6184 73.5835 36.8 73.58C37.46 73.63 37.8 73.64 38.44 73.67C38.838 73.6976 39.238 73.674 39.63 73.6C39.8954 73.5339 40.1418 73.4073 40.35 73.23C40.7051 72.9096 41.0028 72.5308 41.23 72.11H41.51C41.2 72.93 41.04 73.34 40.7 74.11C38.1949 74.1484 35.6907 73.9913 33.21 73.64V73.42H33.55C33.7717 73.4508 33.9975 73.4303 34.21 73.36C34.2808 73.3438 34.3475 73.3133 34.406 73.2703C34.4645 73.2273 34.5135 73.1727 34.55 73.11C34.6468 72.8643 34.7009 72.6039 34.71 72.34C34.93 70.25 35.04 69.2 35.25 67.1C35.339 66.769 35.318 66.418 35.19 66.1C35.0991 66.0019 34.9894 65.923 34.8675 65.868C34.7455 65.8131 34.6138 65.7832 34.48 65.78H34.18V65.56C36.3094 65.8631 38.4595 65.9969 40.61 65.96C40.61 66.67 40.67 67.03 40.72 67.74H40.51C40.4631 67.4312 40.3615 67.1332 40.21 66.86C40.0974 66.6932 39.9371 66.5642 39.75 66.49C39.4644 66.4066 39.1673 66.3695 38.87 66.38C37.95 66.46 37.51 66.43 36.57 66.36Z"
                              fill="#231F20"/>
                        <path d="M47.88 73.7C46.3323 71.652 44.9321 69.4965 43.69 67.25L44.04 72.66C44.04 73.16 44.15 73.46 44.29 73.58C44.5385 73.7499 44.844 73.8146 45.14 73.76H45.49V73.99C44.13 74.1 43.49 74.14 42.1 74.18V73.96H42.51C42.6694 73.9739 42.8297 73.9494 42.9776 73.8885C43.1255 73.8276 43.2567 73.7321 43.36 73.61C43.4864 73.335 43.5248 73.0276 43.47 72.73L43.19 67.45C43.1987 67.1843 43.1439 66.9203 43.03 66.68C42.9473 66.5547 42.8288 66.4572 42.69 66.4C42.4492 66.3173 42.1936 66.2866 41.94 66.31V66.09C42.88 66.09 43.36 66.04 44.3 65.97C45.4666 68.0537 46.7694 70.058 48.2 71.97C49.0417 69.7582 49.7365 67.4933 50.28 65.19C51.21 65 51.68 64.89 52.61 64.66V64.87L52.32 64.94C52.1784 64.9616 52.044 65.0164 51.9276 65.0998C51.8111 65.1832 51.716 65.2929 51.65 65.42C51.595 65.717 51.6157 66.0231 51.71 66.31C52.18 68.37 52.41 69.4 52.88 71.47C52.99 71.96 53.13 72.24 53.28 72.33C53.4155 72.398 53.5635 72.4375 53.7148 72.4461C53.8662 72.4547 54.0177 72.4322 54.16 72.38L54.51 72.19L54.56 72.41C52.95 72.81 52.13 72.99 50.49 73.28V73.06L50.83 73C50.9903 72.9874 51.1456 72.9386 51.2842 72.8572C51.4228 72.7758 51.541 72.6639 51.63 72.53C51.712 72.239 51.712 71.931 51.63 71.64C51.2 69.52 50.98 68.46 50.56 66.34C49.9368 68.8276 49.1449 71.2699 48.19 73.65L47.88 73.7Z"
                              fill="#231F20"/>
                        <path d="M59.16 70.81L59.24 71.02C57.64 71.58 56.83 71.82 55.24 72.25L55.18 72.04L55.52 71.95C55.6774 71.9217 55.8273 71.8608 55.9598 71.7712C56.0924 71.6817 56.2049 71.5655 56.29 71.43C56.3513 71.117 56.3164 70.7928 56.19 70.5C55.61 68.5 55.31 67.5 54.73 65.5C54.6664 65.2354 54.5618 64.9823 54.42 64.75C54.3382 64.6538 54.2247 64.59 54.1 64.57C53.9065 64.52 53.7035 64.52 53.51 64.57L53.22 64.65L53.16 64.43C54.56 64.06 55.25 63.85 56.63 63.37L56.7 63.58L56.41 63.68C56.272 63.7123 56.1434 63.7761 56.0341 63.8663C55.9248 63.9565 55.8379 64.0707 55.78 64.2C55.7289 64.5128 55.7742 64.8337 55.91 65.12C56.54 67.12 56.86 68.12 57.49 70.12C57.5598 70.3875 57.6748 70.6412 57.83 70.87C57.9326 70.9608 58.0631 71.0137 58.2 71.02C58.4257 71.0464 58.6545 71.0225 58.87 70.95L59.16 70.81Z"
                              fill="#231F20"/>
                        <path d="M62.24 60.8C62.74 61.8 62.99 62.3 63.48 63.31L63.26 63.42C63.0147 63.0287 62.6954 62.689 62.32 62.42C61.9907 62.2202 61.615 62.1098 61.23 62.1C60.8364 62.0772 60.4428 62.1457 60.08 62.3C59.7086 62.4465 59.4006 62.7191 59.21 63.07C59.1227 63.2201 59.0701 63.3878 59.0563 63.5609C59.0425 63.734 59.0676 63.908 59.13 64.07C59.2286 64.3013 59.4107 64.487 59.64 64.59C60.369 64.8432 61.1388 64.9585 61.91 64.93C62.578 64.9275 63.2456 64.9609 63.91 65.03C64.2661 65.0735 64.6079 65.1965 64.91 65.39C65.1877 65.5581 65.4129 65.8006 65.56 66.09C65.7005 66.3731 65.7686 66.6867 65.7581 67.0026C65.7477 67.3185 65.659 67.6268 65.5 67.9C65.1108 68.6075 64.489 69.1586 63.74 69.46C63.4881 69.5631 63.2311 69.6531 62.97 69.73C62.6403 69.804 62.3063 69.8575 61.97 69.89C61.6655 69.9135 61.364 69.9671 61.07 70.05C60.968 70.079 60.8816 70.1473 60.83 70.24C60.7873 70.3699 60.7873 70.5101 60.83 70.64L60.57 70.73L59.57 68.13L59.81 68.04C60.0483 68.4335 60.3648 68.7738 60.74 69.04C61.0943 69.2482 61.499 69.3555 61.91 69.35C62.4061 69.3556 62.8974 69.2532 63.35 69.05C63.8271 68.8679 64.2311 68.5341 64.5 68.1C64.5961 67.9401 64.6526 67.7596 64.6648 67.5735C64.677 67.3874 64.6445 67.201 64.57 67.03C64.4674 66.8399 64.3154 66.6809 64.13 66.57C63.8878 66.4289 63.6186 66.3403 63.34 66.31C63.13 66.31 62.57 66.31 61.68 66.22C61.0379 66.2064 60.3984 66.1327 59.77 66C59.4081 65.9295 59.0665 65.7792 58.77 65.56C58.5127 65.3588 58.3183 65.0882 58.21 64.78C58.1126 64.5095 58.0748 64.2212 58.0989 63.9348C58.1231 63.6483 58.2087 63.3704 58.35 63.12C58.6612 62.543 59.1684 62.0961 59.78 61.86C60.2368 61.67 60.7254 61.5682 61.22 61.56C61.3966 61.5626 61.5723 61.5355 61.74 61.48C61.8293 61.4407 61.9007 61.3694 61.94 61.28C61.9849 61.1471 61.9849 61.003 61.94 60.87L62.24 60.8Z"
                              fill="#231F20"/>
                        <path d="M32.11 2.06001C26.6337 3.60728 21.5138 6.21306 17.04 9.72999C13.4024 12.4497 10.1759 15.6796 7.45999 19.32C0.179989 29.63 -1.83001 46.76 6.08999 60.96C15.2 77.32 32.39 80.67 34.03 80.96C55.03 84.69 69.53 69.66 70.74 68.36C72.61 66.36 84.37 53.36 81.43 34.93C78.86 18.93 66.98 10.33 63.07 7.81001C61.08 6.52001 47.51 -1.91999 32.11 2.06001Z"
                              stroke="#231F20" stroke-width="2" stroke-miterlimit="10"/>
                        <path d="M40.18 18.8V29.03L38.86 44.37C38.86 44.61 40.11 52.85 40.15 53.09V53.29H42.78L44.09 43.93L43.37 30.51L43.07 18.8H40.18Z"
                              fill="#231F20"/>
                        <path d="M35.78 19.04C35.0053 18.3106 34.1338 17.6914 33.19 17.2C32.8418 17.0405 32.4759 16.923 32.1 16.85C31.7959 16.8001 31.4881 16.7767 31.18 16.78C29.0693 17.0024 26.9899 17.4585 24.98 18.14C22.19 19.08 20.8 19.55 19.22 19.38C17.8221 19.2407 16.4899 18.7182 15.37 17.87C14.6 17.27 13.37 16.34 13.61 15.2C13.7054 14.7555 13.9438 14.3544 14.2887 14.0582C14.6337 13.762 15.0661 13.587 15.52 13.56C16.52 13.56 16.86 14.76 17.72 15.48C20.25 17.59 24.51 13.19 30.59 13.7C33.8 13.96 33.59 15.26 38.4 15.89C40.7284 16.2683 43.1092 16.1731 45.4 15.61C48.28 14.82 47.8 13.98 49.64 13.83C52.21 13.63 53.75 15.23 58.82 16.44C58.91 16.44 59.22 16.51 59.63 16.61C60.48 16.82 61.48 17.14 64.3 16.23C65.25 15.92 64.42 14.71 65.12 14.11C65.82 13.51 67.65 13.64 68 14.38C68.42 15.28 66.87 16.76 66.49 17.12C63.49 19.96 59.06 19.68 58.68 19.65L58.07 19.58C57.5405 19.4914 57.0189 19.361 56.51 19.19C55.77 18.9 54.97 18.65 53.35 18.19C50.99 17.48 49.62 17.08 48.68 17.75C48.51 17.88 48.63 17.85 47.93 18.54C46.76 19.71 46.33 19.9 45.93 19.92C45.6613 19.9395 45.3923 19.8878 45.15 19.77C42.66 18.6 37.93 20.93 35.78 19.04Z"
                              fill="#231F20"/>
                        <path d="M40.92 54.75H38.85L32.6 57.6L29.86 59.24V60.88H52.98V59.24L44.11 54.75H40.92Z"
                              fill="#231F20"/>
                        <path d="M17.21 20.76L25.51 41.04C25.7 41.48 25.45 41.45 25.24 41.45L8.10998 41.7C8.09229 41.6996 8.07495 41.6949 8.05945 41.6864C8.04394 41.6779 8.03073 41.6658 8.02092 41.6511C8.0111 41.6363 8.00498 41.6195 8.00308 41.6019C8.00118 41.5843 8.00354 41.5665 8.00998 41.55L16.8 20.55"
                              stroke="#231F20" stroke-miterlimit="10"/>
                        <path d="M16.99 20.84V41.92" stroke="#231F20" stroke-miterlimit="10"/>
                        <path d="M39.98 52.99C39.685 53.3125 39.5272 53.7373 39.5403 54.1742C39.5534 54.6111 39.7362 55.0257 40.05 55.33C40.4 55.51 40.64 55.1001 41.66 54.9701C42.68 54.8401 42.87 55.09 43.12 54.82C43.2631 54.5642 43.319 54.2687 43.2793 53.9782C43.2397 53.6878 43.1065 53.4181 42.9 53.21C42.54 52.83 42 52.84 40.9 52.85C40.42 52.85 40.16 52.86 39.98 52.99Z"
                              fill="#231F20"/>
                        <path d="M15.36 19.9C15.7773 20.3919 16.3724 20.6986 17.0151 20.7529C17.6579 20.8073 18.296 20.6049 18.79 20.19C19.1887 19.8453 19.4569 19.3741 19.5497 18.8553C19.6425 18.3366 19.5544 17.8016 19.3 17.34C18.45 16.21 15.78 16.6 15.14 18C15.0094 18.3087 14.961 18.646 14.9996 18.979C15.0381 19.312 15.1623 19.6293 15.36 19.9V19.9Z"
                              stroke="#231F20" stroke-miterlimit="10"/>
                        <path d="M8.32002 41.61C8.25297 41.5777 8.17697 41.569 8.10436 41.5853C8.03174 41.6017 7.96678 41.6421 7.92003 41.7C7.73003 41.98 10.01 44.7 13.51 45.78C13.51 45.78 17.51 47.02 22.82 44.6C23.167 44.435 23.5013 44.2446 23.82 44.03C24.1199 43.8291 24.401 43.6014 24.66 43.35C25.1532 42.7335 25.5294 42.032 25.77 41.28"
                              fill="#231F20"/>
                        <path d="M41.28 9.37001C39.56 9.59001 37.64 14.65 39.6 16.46C40.0977 16.8688 40.7116 17.1101 41.3544 17.1496C41.9972 17.1891 42.636 17.0247 43.18 16.68C45.06 15.27 44.18 10.75 42.09 9.59004C41.8527 9.42703 41.5671 9.34943 41.28 9.37001V9.37001Z"
                              fill="#231F20"/>
                        <path d="M16.99 21.1L17.25 41.55" stroke="#231F20" stroke-miterlimit="10"/>
                        <path d="M65.87 17.34C65.03 16.25 62.35 16.62 61.71 17.97" stroke="#231F20"
                              stroke-miterlimit="10"/>
                        <path d="M41.04 12.74C40.6521 12.7994 40.2978 12.9942 40.04 13.29C39.8555 13.4937 39.7323 13.7454 39.6846 14.0161C39.6368 14.2868 39.6664 14.5654 39.77 14.82C39.9288 15.0618 40.1505 15.2556 40.4113 15.3807C40.6721 15.5058 40.962 15.5575 41.25 15.53C42.16 15.48 41.84 12.63 41.04 12.74Z"
                              fill="white" stroke="#231F20" stroke-miterlimit="10"/>
                        <path d="M63.58 20.52L71.9 40.8C72.09 41.24 71.84 41.21 71.63 41.21L54.5 41.47C54.4819 41.4681 54.4646 41.462 54.4492 41.4524C54.4338 41.4427 54.4208 41.4297 54.4111 41.4143C54.4015 41.3989 54.3955 41.3815 54.3936 41.3634C54.3916 41.3453 54.3938 41.3271 54.4 41.31L63.19 20.37"
                              stroke="#231F20" stroke-miterlimit="10"/>
                        <path d="M63.36 20.6V41.69" stroke="#231F20" stroke-miterlimit="10"/>
                        <path d="M61.73 19.6599C62.1473 20.1519 62.7424 20.4586 63.3852 20.5129C64.0279 20.5673 64.6661 20.3649 65.16 19.95C65.5571 19.6042 65.8242 19.1331 65.9169 18.6148C66.0097 18.0965 65.9226 17.562 65.67 17.0999C64.96 16.0999 62.34 16.55 61.51 17.76C61.3558 18.0632 61.2944 18.4052 61.3336 18.7431C61.3727 19.0811 61.5106 19.4 61.73 19.6599Z"
                              stroke="#231F20" stroke-miterlimit="10"/>
                        <path d="M54.69 41.37C54.6227 41.3347 54.5447 41.3254 54.471 41.3439C54.3972 41.3623 54.3328 41.4072 54.29 41.47C54.1 41.75 56.38 44.47 59.88 45.54C59.88 45.54 63.88 46.79 69.19 44.37C69.5361 44.1995 69.8702 44.0057 70.19 43.79C70.4925 43.5926 70.774 43.3647 71.03 43.11C71.5232 42.4935 71.8994 41.7919 72.14 41.04"
                              fill="#231F20"/>
                        <path d="M63.36 20.86L63.62 41.31" stroke="#231F20" stroke-miterlimit="10"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_54_125">
                            <rect width="82.89" height="82.55" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="frontController.php?action=readAll">Questions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="frontController.php?action=create">Créer une Question</a>
                    </li>
                </ul>
                <div id="searchBox" class="mx-3">
                    <form method="get">
                        <input type="search" name="element" placeholder="Recherche...">
                        <input type='hidden' name='action' value='search'>
                        <input type="submit" value="Valider">
                    </form>
                </div>
                <form class="d-flex" id="signButtons">
                    <a class="btn btn-outline-success" href="frontController.php?action=login&controller=utilisateur">Sign
                        In</a>
                    <a class="btn btn-outline-success" href="frontController.php?controller=utilisateur&action=create">Sign
                        Up</a>
                </form>
                <div class="nav-item">
                    <a class="nav-link" href="frontController.php?action=read&controller=utilisateur&login=paulDupont">
                        <img id="accountImg" alt="compte" src="assets/img/account.png">
                        </a>
                    <!--login default pour l'instant-->
                </div>
            </div>
        </div>
    </nav>
</header>
<main>
    <?php
    require __DIR__ . "/{$pathBodyView}";
    ?>
</main>
<footer>

</footer>
</body>
</html>