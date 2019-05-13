 <script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<!-- include A-Frame obviously -->
<!--<script src="aframe.min.js"></script>-->
<!-- include ar.js for A-Frame -->
<!--<script src="aframe-ar.js"></script>-->

<script src="https://aframe.io/releases/0.9.0/aframe.min.js"></script>
<script src="https://rawgit.com/jeromeetienne/AR.js/master/aframe/build/aframe-ar.min.js"></script>
<script src="https://rawgit.com/donmccurdy/aframe-extras/master/dist/aframe-extras.loaders.min.js"></script>
    
 <!--Let browser know website is optimized for mobile-->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<script src='https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js'></script>


<script src='pdfMake/pdfmake.min.js'></script>
<script src='pdfMake/vfs_fonts.js'></script>
<head>  
    <link rel="stylesheet" href="style.css">

</head>
<body onload="$('#urlQrCode').hide();$('#wasd').hide()">
    <div id="botonesIniciales">
        <button id="btnEscanear" onclick="escanea()" >Escanear</button>

        <button id="btnGenerarID" onclick="generaID()" >Generar ID</button>
    </div>
<div style='position: fixed; top: 10px; width:100%; text-align: center; z-index: 1;'>
    

    <form id="wasd">
        Nombre: <input type="text" name="nombre" id="nom" value="" required><br>
        <br>
        Apellido: <input type="text" name="apellido" id="ape" value="" required><br>
        
        <!--<br>
        Ocupacion: <input type="text" name="ocupacion" cols="30" rows="5" style="width:200px; height:50px;" id="ocu" value="" required>
        <br>-->
        <br>
        Descripcion:
        <br>
        <textarea name="descripcion" form="wasd" cols="30" rows="3" required></textarea>
        <br>
        <br>
        Foto de perfil: <input type="file" name="pic" id="img" accept="image/*" required><br>
        <br>
        <br>
        <div id="qrcode"></div>
        <button type="submit">Listo</button>
        <br>
        <br>
        <input id="urlQrCode" type="text">
        <br>
        <br>
        <button type="button" onClick="updateARCode()">Generar QR</button>
        <div class="valign center" style="width: 100%;" id='arcode-container'></div>

    </form>
</div>

</body>
    
        <script>

        function escanea(){
            $('#botonesIniciales').hide();
            $('#wasd').hide();
            $('#arcode-container').hide();      
            cargaEscena(); //No va a cargar porque no se le pasaron los parametros
        }

        function generaID(){
            $('#botonesIniciales').hide();
            $('#wasd').show();
            $('#arcode-container').show();
        }
        document.getElementById("wasd").onsubmit = function test(e){
        e.preventDefault();
        $('#wasd').hide();
        $('#arcode-container').hide();
        
        var inputs = document.querySelectorAll("input, select, textarea");

        inputs.forEach(input => {
            input.addEventListener(
            "invalid",
            event => {
                input.classList.add("error");
            },
            false
            );
        });
        cargaEscena();

        };
        
        
        function cargaEscena(){
            var name = document.getElementById("nom").value;
            var surname = document.getElementById("ape").value;
            var imgName = document.getElementById("img").value;
            console.log("Nombre: " + name);
            console.log("Apellido: " + surname);
            console.log("imgName: " + imgName);
            //document.write("<a-scene embedded arjs><!-- create your content here. just a box for now --><a-entity text__text='align: center; color:  #000000; value: Nombre: " + name + "; width: 10' position='0 0.5 0'></a-entity><a-box position='0 0.5 0' material='opacity: 1;'></a-box><!-- define a camera which will move according to the marker position --><a-marker-camera preset='hiro'></a-marker-camera></a-scene>");  
        
        
            var sceneEl = document.createElement('a-scene');
            var assetsEl = document.createElement('a-assets');
            sceneEl.appendChild(assetsEl);
        
            var cameraEl = document.createElement('a-marker-camera');   
            //cameraEl.setAttribute('preset','hiro');
            cameraEl.setAttribute('preset','custom');
            cameraEl.setAttribute('type','pattern');
            cameraEl.setAttribute('url','https://raw.githubusercontent.com/germanalvarez15/imageTargetARjs/master/gerMarker3.patt');
            sceneEl.appendChild(cameraEl);
            //Foto perfil
            var planEl = document.createElement('a-entity');
            planEl.setAttribute('geometry', {
                primitive: 'plane',
                height: 1,
                width: 1,
            });
            planEl.setAttribute('material', {
                src: URL.createObjectURL(document.getElementById("img").files[0]),

            });

            planEl.setAttribute('position','0 -0.15 0.050');
            planEl.setAttribute('rotation', '270 0 0');
            sceneEl.appendChild(planEl);

            //Nombre
            var txtNameEl = document.createElement('a-entity');
            txtNameEl.setAttribute('text__text',{
            'value':name,
            'width':5,
            'align':'center',
            'color': '#00CFFF',
            });
            txtNameEl.setAttribute('position','0 -0.1 -0.787');
            txtNameEl.setAttribute('rotation','270 0 0');
            sceneEl.appendChild(txtNameEl);

            //Apellido
            var txtApeEl = document.createElement('a-entity');
            txtApeEl.setAttribute('text__text',{
            'value':surname,
            'width':5,
            'align':'center',
            'color': '#00CFFF',
            });
            txtApeEl.setAttribute('position','0 -0.1 -0.55');
            txtApeEl.setAttribute('rotation','270 0 0');

            sceneEl.appendChild(txtApeEl);
            document.body.appendChild(sceneEl);
        }
//////////////////////////////////////////////////////////////////////////////
//                PDF Generation
//////////////////////////////////////////////////////////////////////////////

function generatePdf(){
        console.log('generate PDF')
        
        var urlQrCode = document.querySelector('#urlQrCode').value
        
        var docDefinition = {
                header: [
                        {
                                text: 'WebAR Portfolio by @alvarezgerman15 - https://twitter.com/alvarezgerman15',
                                margin: [0, 0],
                                alignment: 'center',
                        },                        
                ],
                content: [
                        {
                                image: canvas.toDataURL(),
                                width: 320,
                                alignment: 'center',
                        },
                        {
                                text: [                                        
                                        {
                                                text: '\nCodigo de escaneo',
                                    fontSize: 30,
                                    bold: true,
                                        },
                                        {
                                                text: 'para',
                                    fontSize: 20,
                                    bold: false,
                                        }
                                ],
                                alignment: 'center',
                        },
                        {
                                text: urlQrCode,
                                alignment: 'center',
                                margin: [0, 10],
                        },
                        {
                                text: '¿Como funciona?',
                    fontSize: 24,
                                margin: [0, 20],
                        },
                        {
                                text: 'Paso 1 - Imprime el codigo',
                    bold: true,
                    fontSize: 15,
                        },
                        {
                                text: [
                                        'Imprime el codigo QR de arriba y pegalo en tu pase del evento.',
                                ],
                                margin: [0, 10, 0 , 30],
                },
                        {
                                text: 'Paso 2 - Escanea el codigo',
                    bold: true,
                    fontSize: 15,
                        },
                        {
                                text: [
                                        'Agarra un celular y escanea el codigo QR con la camara del sistema. ',
                                        'Una vez que lo reconozca, te pedirá para abrir un enlace. Abrílo. ',
                                ],
                                margin: [0, 10, 0 , 30],
                },        
                        {
                                text: 'Paso 4 - Permisos',
                    bold: true,
                    fontSize: 15,
                        },
                        {
                                text: [
                                        'Una vez abierto el sitio, te pedirá por permisos para acceder a la camara. Aceptalo.',                                       
                                ],
                                margin: [0, 10, 0 , 30],
                },            
                        {
                                text: 'Paso 5 - Escanea de nuevo el codigo',
                    bold: true,
                    fontSize: 15,
                        },
                        {
                                text: [
                                        'Una vez que hayas aceptado los permisos de la camara, escanea de nuevo el codigo',
                                        'de arriba y podras ver tu portfolio digital',
                                        { text: 'Listo', bold: true, },
                                        'Ahora cualquiera que escanee tu codigo podrá ver tu portfolio digital',                                        
                                ],
                                margin: [0, 10, 0 , 30],
                },        
                ],
        }
        pdfMake.createPdf(docDefinition).open();
        // pdfMake.createPdf(docDefinition).download('optionalName.pdf');
}


        //--------------------------------------------------------------

        var canvas = document.createElement('canvas');
document.querySelector('#arcode-container').appendChild(canvas)
canvas.width  = 900;
canvas.height = 900;
canvas.style.width  = '20em';
canvas.style.height = '20em';
canvas.style.position = 'relative';
canvas.id="canvasQRImg";

var context = canvas.getContext('2d')

var hiroImage = new Image;
hiroImage.onload = function() {
        console.log('hiro image loaded')
        
        if( location.hash.substr(1) !== '' ){
                var parameters = JSON.parse(decodeURIComponent(location.hash.substr(1)))
                document.querySelector('#urlQrCode').value = parameters.urlQrCode
                //document.querySelector('#hideUiEnabled').checked = parameters.hideUiEnabled
                //document.querySelector('#saveInUrl').checked = true
// debugger;
        }else{
                document.querySelector('#urlQrCode').value = 'https://germanwebar.000webhostapp.com'
        }

        updateARCode()
}
hiroImage.src = 'gerMarker3.png';

function updateARCode(){
        var urlQrCode = document.querySelector('#urlQrCode').value
        //var hideUiEnabled = document.querySelector('#hideUiEnabled').checked
        //var saveInUrl = document.querySelector('#saveInUrl').checked
        var parameters = {
                urlQrCode : urlQrCode,
                //hideUiEnabled: hideUiEnabled,
        }
        
        // generate the ar-code canvas
        generateArCodeCanvas(canvas, urlQrCode, function onReady(){
                console.log('ar-code generated for', urlQrCode)
        })

        /*if( hideUiEnabled === true ){
                document.querySelector('#row-ui').style.display = 'none'
                document.querySelector('#btnShowUI').style.display = 'block'
        }else{
                document.querySelector('#row-ui').style.display = 'block'
                document.querySelector('#btnShowUI').style.display = 'none'                
        }*/
        
        //////////////////////////////////////////////////////////////////////////////
        //                update location.hash if suitable
        //////////////////////////////////////////////////////////////////////////////
        /*if( saveInUrl === true ){
                location.hash = '#' + encodeURIComponent(JSON.stringify(parameters))
        }else{
                // magic to remove the old location.hash
                history.pushState("", document.title, location.pathname + location.search);
        }*/
}

//////////////////////////////////////////////////////////////////////////////
//                Code Separator
//////////////////////////////////////////////////////////////////////////////

/**
 * Generate AR-Code
 */
function generateArCodeCanvas(canvas, text, onLoad){
        var context = canvas.getContext('2d')
        
        context.drawImage(hiroImage, 0, 0, canvas.width, canvas.height);

        generateQrCodeImage(text, function onLoaded(qrCodeImage){
                console.log('qrcode generated')
                context.drawImage(qrCodeImage,canvas.width*0.40,canvas.height*0.32,canvas.width*0.20, canvas.height*0.20);      
                
                onLoad && onLoad()
        })
}


/**
 * Generate AR-Code
 */
function generateQrCodeImage(text, onLoaded){
        var container = document.createElement('div')

        var qrcode = new QRCode(container, {
                text: text,
                width: 256,
                height: 256,
                colorDark : '#000000',
                colorLight : '#ffffff',
                // correctLevel : QRCode.CorrectLevel.H
        });

        var qrCodeImage = container.querySelector('img')
        qrCodeImage.addEventListener('load', function(){
                onLoaded(qrCodeImage)
        })
        //var qrImageToDownload = qrCodeImage.url;
        document.querySelector('#arcode-container').appendChild(canvas)


}

</script>

