<!DOCTYPE html>
<html>
<title>{{ $title }}</title>
<body>
    <style type="text/css">
    	 @page {
                    /width: 21 cm;/
                    /height: 29.7cm;/
                    margin-top: 2cm;
                    margin-bottom: 2.3cm;
                     /font-family: 'DejaVu Sans', serif;/

                }
        header {
            position: relative;
            margin-top: -1 cm;
            margin-left: 0.5 cm;
            margin-right: 0.5 cm;
        }
        main{
        	position: relative;
        	margin-top: 0.2 cm;
        	margin-right: 0.5 cm;
        	margin-bottom: -1.2 cm;
        	margin-left: 0.5 cm;
        	width: 100%;
        }


        footer {
     		position: fixed;
	      	left: 0cm;
	      	right: 0cm;
	      	height: 2cm;
	      	bottom: -2.2cm;



        }
       	.table-footer tr td{
       		line-height: 100%;
       		text-align: justify;
       		font-size: 8pt;
       	}

    </style>


    <header>
        <table width="100%" style="border-bottom:2px solid #192213;">
			<tr>
				<td  width="10%">
					<img src="{{ $logo_path }}" style="width: 3cm;height: 3cm;">
				</td>
				<td align="center">
						<div>
							<font size="20pt" style="color:white">
								<b>UNIVERSITAS JAMBI</b>
							</font>
						</div>
				</td>
			</tr>
		</table>
    </header>
    <footer>
    	<table class="table-footer">
    		<tr>
    			<td rowspan="3" width="10%" >
    				<img src="" width="130px" height="50px">
    			</td>
    			<td colspan="2" style="border-bottom:1px solid black;">Catatan:</td>
    		</tr>
    		<tr>

    			<td valign="top" width="2%">1.&nbsp; </td>
    			<td valign="top"> </td>

    		</tr>
    		<tr>
    			<td valign="top"> 2.&nbsp;</td>
    			<td valign="top">

    			</td>
    		</tr>
    	</table>
    </footer>
    <main>
        <table class="table">
            <thead>
                <tr>
                    <th>pertama</th>
                    <th>kedua</th>
                    <th>ketiga</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </main>
</body>
</html>
