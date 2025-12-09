@extends('layouts.appSales') @section('content')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
    <div class="container-fluid">
        <div id="qr-code-uji-coba">
            <input class="input" id="text-content" type="text"
                value="https://wa.me/+6289664290102" style="width:80%"><br>
            <input class="input" type="text" name="text-content2" id="text-content2" placeholder="url_Encode"><br>
            <div id="qrcode" style="width:200px; height:200px; margin-top:15px;">
            </div>
            <span id="text-qr"></span>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/qrcode.js') }}"></script>
    <style>
        #text-content2 {
            /* display: none; */
        }

        @media print {

            #text-content,
            #text-content2 {
                display: none !important;
            }

            #qrcode {
                display: block !important;
            }

            #text-qr {
                display: block;
                font-size: 18px;
            }
        }
    </style>
    <script type="text/javascript">
        var elText = document.getElementById("text-content");
        var elText2 = document.getElementById("text-content2");
        var textqr = document.getElementById("text-qr");

        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 200,
            height: 200,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        elText2.addEventListener("change", function() {
            if (this.selectedIndex !== 0) {
                this.setCustomValidity("Tekan Enter!");
                this.reportValidity();
            }
        });

        elText2.addEventListener("keypress", function(event) {
            console.log(event.key);
            if (event.key == "Enter") {
                event.preventDefault();
                // elText2.value = encodeURIComponent(this.value);
                makeCode();
            }
        });

        function makeCode() {
            if (!elText.value) {
                alert("Input a text");
                elText.focus();
                return;
            }
            textqr.innerHTML = elText.value + '?text=' + encodeURIComponent(elText2.value);
            qrcode.makeCode(textqr.innerHTML);
        }

        $("#text-content").
        on("keydown", function(e) {
            if (e.keyCode == 13) {
                elText2.focus();
            }
        });
    </script>
@endsection
