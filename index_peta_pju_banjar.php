<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        
		<link rel="stylesheet" href="./resources/ol.css" />
        <link rel="stylesheet" href="./resources/ol3-layerswitcher.css">
        <link rel="stylesheet" href="./resources/qgis2web.css">
        
		<style>
			html, body {
				<!--background-color: #ffffff;	 #4d4d4d; -->
			}
        </style>
        <script>var test = <?php echo $aaaaa;?>;</script>
		<!--script>var test1 = '<?php //echo $aaaaa;?>';</script-->
		<!--script src="layers/aad.js"></script-->
		
		<script src="resources/polyfills.js"></script>
        <script src="./resources/ol.js"></script>
        <script src="resources/OSMBuildings-OL3.js"></script>
        <script src="./resources/ol3-layerswitcher.js"></script>
		
        <script src="layers/Kecamatan.js"></script>
		<script src="layers/Desa.js"></script>
		<script src="layers/Sungai.js"></script>
		<script src="layers/Jalan.js"></script>
		<script src="layers/TitikLPJUDaya.js"></script>
		<script src="layers/TitikLPJUJenisTitik.js"></script>
		<script src="layers/TitikLPJUDesa.js"></script>
		<script src="layers/TitikLPJU.js"></script>
        
		<script src="styles/Kecamatan_style.js"></script>
		<script src="styles/Desa_style.js"></script>
		<script src="styles/Sungai_style.js"></script>
		<script src="styles/Jalan_style.js"></script>
		<script src="styles/TitikLPJUDaya_style.js"></script>
		<script src="styles/TitikLPJUJenisTitik_style.js"></script>
		<script src="styles/TitikLPJUDesa_style.js"></script>
		<script src="styles/TitikLPJU_style.js"></script>
        
		<script src="./layers/layers.js" type="text/javascript"></script> 
		<script src="layers/aaa.js"></script>
       
		<style>
        html, body, #map {
            width: 100%;
            height: 100%;
            padding: 0;
            margin: 0;
        }
        </style>
        
		<title></title>
    </head>

    <body>
		<h1>halo</h1>
        <div id="map">
            <div id="popup" class="ol-popup">
                <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                <div id="popup-content"></div>
            </div>
        </div>
        <script src="./resources/qgis2web.js"></script>
        <script src="./resources/Autolinker.min.js"></script>
		
		<style>
			.tooltip {
				position: relative;
				background: rgba(0, 0, 0, 0.5);
				border-radius: 4px;
				color: white;
				padding: 4px 8px;
				opacity: 0.7;
				white-space: nowrap;
			}
			
			.tooltip-measure {
				opacity: 1;
				font-weight: bold;
			}
			
			.tooltip-static {
				background-color: #ffcc33;
				color: black;
				border: 1px solid white;
			}
			
			.tooltip-measure:before,
			.tooltip-static:before {
				border-top: 6px solid rgba(0, 0, 0, 0.5);
				border-right: 6px solid transparent;
				border-left: 6px solid transparent;
				content: "";
				position: absolute;
				bottom: -6px;
				margin-left: -7px;
				left: 50%;
			}
			
			.tooltip-static:before {
				border-top-color: #ffcc33;
			}
			
			.measure-control {
				top: 65px;
				left: .5em;
			}
			
			.ol-touch .measure-control {
				top: 80px;
			}
		</style>

		<?php
   include ("../layout/footer.php");
?>
    </body>
</html>
