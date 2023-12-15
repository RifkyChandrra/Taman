<?php
    $con = mysqli_connect("localhost", "root", "", "rptra_jaksel");

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    $sql = "SELECT * FROM taman";
    $result = mysqli_query($con, $sql);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taman</title>
 
    <?php include 'header.php'; ?>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxrkghJNS72riJjd8voAqAEbstS3PS2W4&callback=initMap" async defer></script>
    <link rel="stylesheet" href="./css/taman-style.css" />
</head>
<body>
    <div id="map-container">
        <div id="map"></div>
        <div class="info-container" id="info-container"></div>
    </div>

    <script>
    var sidebarVisible = false;
    var currentInfoWindow = null;

    function addMarker(latitude, longitude, nama_taman, icon, alamat, fasilitas, jam_operasional, foto, map) {
        var tamanMarker = new google.maps.Marker({
            position: { lat: latitude, lng: longitude },
            map: map,
            title: nama_taman,
            icon: {
                url: 'image/' + icon,
                scaledSize: new google.maps.Size(43, 43)
            }
        });

        var infoWindow = new google.maps.InfoWindow();

        tamanMarker.addListener('click', function () {
            if (currentInfoWindow) {
                currentInfoWindow.close();
            }
            var contentString = '<div class="info-content">' +
                '<table class="info-table">' +
                '<tr><th>Nama</th><td id="info-nama">' + nama_taman + '</td></tr>' +
                '<tr><th>Alamat</th><td id="info-alamat">' + alamat + '</td></tr>' +
                '<tr><th>Fasilitas</th><td id="info-fasilitas">' + fasilitas + '</td></tr>' +
                '<tr><th>Jam Operasional</th><td id="info-jam">' + jam_operasional + '</td></tr>' +
                '<tr><th>Foto</th><td id="info-foto" class="print-img"><img src="image/taman/' + foto + '" alt="Foto Taman"></td></tr>' +
                '<tr class="no-print"><td colspan="2" class="text-center">' +
                '<div class="button-container">' +
                '<button class="btn btn-primary btn-print" onclick="printInfo()">Print</button>' +
                '<div class="button-spacing"></div>' +
                '<button class="btn btn-danger btn-report" onclick="showReportForm()">Laporkan Masalah</button>' +
                '</div>' +
                '</td></tr>' +
                '</table>' +
                '</div>';

            var infoContainer = document.getElementById('info-container');
            infoContainer.innerHTML = contentString;

            if (!sidebarVisible) {
                toggleSidebar(true);
            }
        });
    }

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -6.261493, lng: 106.8106 },
            zoom: 13
        });

        document.addEventListener('DOMContentLoaded', function () {
            var submitButton = document.getElementById('submitReportButton');
            if (submitButton) {
                submitButton.addEventListener('click', submitReport);
            }
        });

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            $latitude = $row["latitude"];
            $longitude = $row["longitude"];
            $nama_taman = $row["nama_taman"];
            $kategori_id = $row["kategori_id"];
            $alamat = $row["alamat"];
            $fasilitas = $row["fasilitas"];
            $jam_operasional = $row["jam_operasional"];
            $foto = $row["foto"];

            $icon = ($kategori_id == 1) ? 'majub-icon.png' : 'rptra-icon.png';

            echo "addMarker($latitude, $longitude, '$nama_taman', '$icon', '$alamat', '$fasilitas', '$jam_operasional', '$foto', map);\n";
        }
        ?>

        google.maps.event.addListener(map, 'click', function () {
            if (sidebarVisible) {
                toggleSidebar(false);
            }
        });
    }

    function toggleSidebar(show) {
        var infoContainer = document.getElementById('info-container');
        sidebarVisible = show;

        if (show) {
            infoContainer.style.display = 'block';
            setTimeout(function () {
                infoContainer.style.width = '30%';
            }, 100);
        } else {
            infoContainer.style.width = '0';
            setTimeout(function () {
                infoContainer.style.display = 'none';
            }, 500);
        }
    }

    function printInfo() {
        var contentToPrint = document.getElementById('info-container').innerHTML;

        var printContainer = document.createElement('div');
        printContainer.innerHTML = contentToPrint;

        var elementsToHide = printContainer.querySelectorAll('.no-print');
        elementsToHide.forEach(function (element) {
            element.style.display = 'none';
        });

        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        document.body.appendChild(iframe);

        var iframeDoc = iframe.contentWindow.document;
        iframeDoc.write('<html><head><title>Informasi Taman</title>' +
            '<style>' +
            '   .info-content img {' +
            '       max-width: 80%; ' +
            '       height: auto;' +
            '   }' +
            '</style>' +
            '</head><body>' + printContainer.innerHTML + '</body></html>');
        iframeDoc.close();

        iframe.contentWindow.print();

        iframe.remove();
    }

    function showReportForm() {
        var reportForm = document.createElement('div');
        reportForm.innerHTML = '<h2 style="color: black; font-weight: bold;">Laporkan Masalah</h2>' +
            '<form id="reportForm" onsubmit="submitReport(event); return false;">' +
            '<table class="report-table">' +
            '<tr><td><label for="nama">Nama:</label></td>' +
            '<td><input type="text" id="nama" name="nama" required></td></tr>' +
            '<tr><td><label for="email">Email:</label></td>' +
            '<td><input type="email" id="email" name="email" required></td></tr>' +
            '<tr><td><label for="tanggal">Tanggal:</label></td>' +
            '<td><input type="date" id="tanggal" name="tanggal" required></td></tr>' +
            '<tr><td><label for="deskripsi">Deskripsi Masalah:</label></td>' +
            '<td><textarea id="deskripsi" name="deskripsi" rows="4" required></textarea></td></tr>' +
            '</table>' +
            '<div class="button-container">' +
            '<button type="submit" class="btn btn-primary" id="submitReportButton">Kirim Laporan</button>' +
            '</div>' +
            '</form>';

        var infoContainer = document.getElementById('info-container');
        infoContainer.innerHTML = '';
        infoContainer.appendChild(reportForm);

        if (!sidebarVisible) {
            toggleSidebar(true);
        }
    }

    function submitReport(event) {
        event.preventDefault();
        var reportForm = document.getElementById('reportForm');
        var formData = new FormData(reportForm);

        var submitButton = reportForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;

        fetch('url_server_script.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log('Data from Server:', data);

                if (data.success) {
                    alert('Laporan masalah telah berhasil dikirim!');
                } else {
                    console.error('Error dari server:', data.message);
                    alert('Terjadi kesalahan saat mengirim laporan. Cek konsol untuk informasi lebih lanjut.');
                }
                toggleSidebar(false);
                location.reload();
            })
            .catch(error => {
                console.error('Error during fetch:', error);
                alert('Terjadi kesalahan saat mengirim laporan.');
                toggleSidebar(false);
                location.reload();
            });
    }
</script>

</body>
<script src="./js/script.js"></script>
<script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="./fontawesome/js/all.min.js"></script>  
</html>
<?php
    mysqli_close($con);
?>