<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css">
	<link rel="stylesheet" href="./styles.css">
	<link rel="stylesheet" href="./pdfannotate.css">
</head>
	<style type="text/css">
      body {
        background-color: #333;
        margin: 0;
        padding: 0;
      }
      .container {
        height: 584px;
        width: 100%;
        margin: 20px auto;
      }
      .fullscreen {
        background-color: #333;
      }
    </style>
<body>
<div class="toolbar">
	<div class="tool">
		<span>PDFJS + FabricJS + jsPDF</span>
	</div>
	<div class="tool">
		<label for="">Brush size</label>
		<input type="number" class="form-control text-right" value="1" id="brush-size" max="50">
	</div>
	<div class="tool">
		<label for="">Font size</label>
		<select id="font-size" class="form-control">
			<option value="10">10</option>
			<option value="12">12</option>
			<option value="16" selected>16</option>
			<option value="18">18</option>
			<option value="24">24</option>
			<option value="32">32</option>
			<option value="48">48</option>
			<option value="64">64</option>
			<option value="72">72</option>
			<option value="108">108</option>
		</select>
	</div>
	<div class="tool">
		<button class="color-tool active" style="background-color: #212121;"></button>
		<button class="color-tool" style="background-color: red;"></button>
		<button class="color-tool" style="background-color: blue;"></button>
		<button class="color-tool" style="background-color: green;"></button>
		<button class="color-tool" style="background-color: yellow;"></button>
	</div>
	<div class="tool">
		<button class="tool-button active"><i class="fa fa-hand-paper-o" title="Free Hand" onclick="enableSelector(event)"></i></button>
	</div>
	<div class="tool">
		<button class="tool-button"><i class="fa fa-pencil" title="Pencil" onclick="enablePencil(event)"></i></button>
	</div>
	<div class="tool">
		<button class="tool-button"><i class="fa fa-font" title="Add Text" onclick="enableAddText(event)"></i></button>
	</div>
	<div class="tool">
		<button class="tool-button"><i class="fa fa-long-arrow-right" title="Add Arrow" onclick="enableAddArrow(event)"></i></button>
	</div>
	<div class="tool">
		<button class="tool-button"><i class="fa fa-square-o" title="Add rectangle" onclick="enableRectangle(event)"></i></button>
	</div>
	<div class="tool">
		<button class="tool-button"><i class="fa fa-picture-o" title="Add an Image" onclick="addImage(event)"></i></button>
	</div>
	<div class="tool">
		<button class="btn btn-danger btn-sm" onclick="deleteSelectedObject(event)"><i class="fa fa-trash"></i></button>
	</div>
	<div class="tool">
		<button class="btn btn-danger btn-sm" onclick="clearPage()">Clear Page</button>
	</div>
	<div class="tool">
		<button class="btn btn-info btn-sm" onclick="showPdfData()">{}</button>
	</div>
	<div class="tool">
		<button class="btn btn-light btn-sm" onclick="drawRect()"><i class="fa fa-save"></i> Draw </button>
	</div>
</div>
<div id="pdf-container" class="container"></div>

<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dataModalLabel">PDF annotation data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<pre class="prettyprint lang-json linenums">
				</pre>
			</div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
<script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.3.0/fabric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.2.0/jspdf.umd.min.js"></script>
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.js"></script>
<script src="./arrow.fabric.js"></script>
<script src="./sample_output.js"></script>
<script src="./pdfannotate.min.js"></script>
<script src="./script.js"></script>

<script src="js/jquery.min.js"></script>
<script src="js/html2canvas.min.js"></script>
<script src="js/three.min.js"></script>
<script src="js/pdf.min.js"></script>
<script src="js/3dflipbook.min.js"></script>

    <script type="text/javascript">

      var template = {
        html: 'templates/default-book-view.html',
        links: [{
          rel: 'stylesheet',
          href: 'css/font-awesome.min.css'
        }],
        styles: [
          'css/short-black-book-view.css'
        ],
        script: 'js/default-book-view.js'
      };

      $('#pdf-container').FlipBook({
        pdf: 'books/pdf/CondoLiving.pdf',
        template: template
      });

	  drawRect = () => {
		
	  }
    </script>
</body>
</html>
