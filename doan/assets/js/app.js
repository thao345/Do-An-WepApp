<script src="https://cdnjs.cloudflare.com/ajax/libs/docxtemplater/3.20.0/docxtemplater.js"></script>
//hóa đơn

$(function () {

    'use strict';

    /**
     * Generating PDF from HTML using jQuery
     */
    $(document).on('click', '#invoice_download_btn', function () {
        var id_donhang = $(this).data('id-donhang');
        var ngaytao = $(this).data('ngaytao');
        
        var contentWidth = $("#invoice_wrapper").width();
        var contentHeight = $("#invoice_wrapper").height();
        var topLeftMargin = 20;
        var pdfWidth = contentWidth + (topLeftMargin * 2);
        var pdfHeight = (pdfWidth * 1.5) + (topLeftMargin * 2);
        var canvasImageWidth = contentWidth;
        var canvasImageHeight = contentHeight;
        var totalPDFPages = Math.ceil(contentHeight / pdfHeight) - 1;
    
        html2canvas($("#invoice_wrapper")[0], {allowTaint: true}).then(function (canvas) {
            canvas.getContext('2d');
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt', [pdfWidth, pdfHeight]);
            pdf.addImage(imgData, 'JPG', topLeftMargin, topLeftMargin, canvasImageWidth, canvasImageHeight);
            for (var i = 1; i <= totalPDFPages; i++) {
                pdf.addPage(pdfWidth, pdfHeight);
                pdf.addImage(imgData, 'JPG', topLeftMargin, -(pdfHeight * i) + (topLeftMargin * 4), canvasImageWidth, canvasImageHeight);
            }
            
            var filename = 'invoice_' + id_donhang + '_' + formatDate(ngaytao) + '.pdf';
            pdf.save(filename);
        });
    });
    
    function formatDate(dateString) {
        var date = new Date(dateString);
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear();
        return  day + month + year;
      }
})

// phiếu cấp dầu
$(function () {

    'use strict';

    /**
     * Generating PDF from HTML using jQuery
     */
    $(document).on('click', '#invoice_download_btn1', function () {
        var id_donhang = $(this).data('id-donhang');
        
        var contentWidth = $("#invoice_wrapper").width();
        var contentHeight = $("#invoice_wrapper").height();
        var topLeftMargin = 20;
        var pdfWidth = contentWidth + (topLeftMargin * 2);
        var pdfHeight = (pdfWidth * 1.5) + (topLeftMargin * 2);
        var canvasImageWidth = contentWidth;
        var canvasImageHeight = contentHeight;
        var totalPDFPages = Math.ceil(contentHeight / pdfHeight) - 1;
    
        html2canvas($("#invoice_wrapper")[0], {allowTaint: true}).then(function (canvas) {
            canvas.getContext('2d');
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt', [pdfWidth, pdfHeight]);
            pdf.addImage(imgData, 'JPG', topLeftMargin, topLeftMargin, canvasImageWidth, canvasImageHeight);
            for (var i = 1; i <= totalPDFPages; i++) {
                pdf.addPage(pdfWidth, pdfHeight);
                pdf.addImage(imgData, 'JPG', topLeftMargin, -(pdfHeight * i) + (topLeftMargin * 4), canvasImageWidth, canvasImageHeight);
            }
            
            var currentDate = new Date();
            var day = String(currentDate.getDate()).padStart(2, '0');
            var month = String(currentDate.getMonth() + 1).padStart(2, '0');
            var year = currentDate.getFullYear();
            
            var ngaythanghientai = day + month + year;
            var filename = 'phieucapdau_' + id_donhang + '_' + ngaythanghientai + '.pdf';
            
            pdf.save(filename);
        });
    });
    
})
