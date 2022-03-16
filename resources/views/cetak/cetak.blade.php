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
        <table width="100%" style="border-bottom:2px solid #0000FF;">
			<tr>
				<td  width="10%">
					<img src="{{ $logo_path }}" style="width: 3cm;height: 3cm;">
				</td>
				<td align="center">
						<div>
							{{-- <font size="{{$ins->pivot->ukuran_font}}pt" style="color:{{$ins->pivot->warna}}">
								@php
                                $bold=DB::table('pengaturan_kop_has_level_instansi')->where('pengaturan_kop_id',$ins->pivot->pengaturan_kop_id)->where('level_instansi_id','<',5)->where('dipakai',1)->orderBy("level_instansi_id",'desc')->first();
                                @endphp

                                @if($bold->level_instansi_id==$ins->id_level_instansi )
									<b>{{$ins->pivot->nama_instansi}}</b>
								@else
									{{$ins->pivot->nama_instansi}}
								@endif
							</font> --}}
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
    			<td valign="top"> UU ITE No 11 Tahun 2008 Pasal 5 Ayat 1 <i>"Informasi Elektronik dan/atau Dokumen Elektronik hasil cetaknya merupakan alat bukti yang sah"</i> </td>

    		</tr>
    		<tr>
    			<td valign="top"> 2.&nbsp;</td>
    			<td valign="top">
    				Dokumen ini ditandatangani secara elektronik menggunakan Sertifikat Elektronik yang diterbitkan oleh Balai Sertifikasi Elektronik (BSrE), Badan Siber dan Sandi Negara (BSSN)
    			</td>
    		</tr>
    	</table>
    </footer>
    <main>
        @yield('body')
    </main>


</body>
</html>
