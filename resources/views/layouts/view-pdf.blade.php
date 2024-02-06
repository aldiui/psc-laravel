<!DOCTYPE html>
<html>
<head>
  <title>PDF.js Express</title>
</head>
<!-- Import PDF.js Express as a script tag from the lib folder using a relative path -->
<script src='/library/pdfview/lib/webviewer.min.js'></script>

<body>
  <div id='viewer' style="width: 1024px; height: 600px; margin: 0 auto;"></div>
  <script>
    WebViewer({
      path: 'WebViewer/lib', // path to the PDF.js Express'lib' folder on your server
      licenseKey: 'Insert commercial license key here after purchase',
      initialDoc: 'https://pdftron.s3.amazonaws.com/downloads/pl/webviewer-demo.pdf',
      // initialDoc: '/path/to/my/file.pdf',  // You can also use documents on your server
    }, document.getElementById('viewer'))
    .then(instance => {
      const docViewer = instance.docViewer;
      const annotManager = instance.annotManager;
      // call methods from instance, docViewer and annotManager as needed
  
      // you can also access major namespaces from the instance as follows:
      // const Tools = instance.Tools;
      // const Annotations = instance.Annotations;
  
      docViewer.on('documentLoaded', () => {
        // call methods relating to the loaded document
      });
    });
  </script>
</body>
</html>
