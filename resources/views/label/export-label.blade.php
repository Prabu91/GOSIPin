<div style="border: 2px solid black; max-width: 600px; padding: 20px; margin: 0 auto; text-align: center; background-color: white; color: black;">
    <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
        <img src="images/logo-bpjs.png" alt="BPJS Logo" style="height: 30px; margin-right: 10px;">
    </div>
    
    <table style="width: 100%; margin-bottom: 20px;">
		<tr>
			<td style="border: 2px solid black; padding: 0; margin: 0; text-align: center; width: 20%;">
				<h2 style="font-size: 12px; font-weight: bold; margin:0; padding:0;">NO. BOX</h2>
				<p style="font-size: 16px; font-weight: bold; background-color: #d0cece; padding: 30px 0 30px 0; margin: 0;">{{$classification->box_number}}</p>
			</td>
			<td style="width: 20%;"></td> <!-- Kolom tengah kosong -->
			<td style="border: 2px solid black; padding: 0; text-align: center; width: 20%;">
				<h2 style="font-size: 12px; font-weight: bold; margin:0; padding:0;">NO. RAK</h2>
				<p style="font-size: 16px; font-weight: bold; background-color: #d0cece; padding: 30px 0 30px 0; margin: 0;">{{$classification->rak_number}}</p>
			</td>
		</tr>
	</table>
	
    
    <div style="border: 2px solid black; padding: 0 10px 0 10px; margin-bottom: 20px; width: 30%; margin-left: auto; margin-right: auto; background-color: #d0cece;">
        <h2 style="font-size: 18px; font-weight: bold; padding: 0; margin: 0;">{{$classification->classificationCode->code}}</h2>
        <p style="font-size: 14px; padding: 0; margin: 6px 0 0 0;">{{$classification->classificationCode->title}}</p>
    </div>

    <div style="border: 2px solid black; background-color: #d0cece; text-align: center;">
        <div style="font-size: 12px; font-weight: bold; text-decoration: underline; background-color: #d0cece; padding: 5px;">
            {{$classification->bagian}}
        </div>
        <div style="padding: 40px; background-color: #d0cece; font-size: 24px; font-weight: bold;">
            <p style="font-size: 16px; font-weight: semi-bold;">{{$classification->uraian_berkas}}</p>
        </div>
    </div>

    <table style="width: 100%;  margin-top: 20px;">
        <tr>
            <td style="border: 2px solid black; padding: 0; margin: 0; text-align: center; width: 20%;">
				<h2 style="font-size: 12px; font-weight: bold; margin:0; padding:0;">Tahun</h2>
				<p style="font-size: 16px; font-weight: bold; background-color: #d0cece; padding: 30px 0 30px 0; margin: 0;">{{$year}}</p>
			</td>
			<td style="width: 20%;"></td>
			<td style="border: 2px solid black; padding: 0; text-align: center; width: 20%;">
				<h2 style="font-size: 12px; font-weight: bold; margin:0; padding:0;">Jumlah</h2>
				<p style="font-size: 16px; font-weight: bold; background-color: #d0cece; padding: 30px 0 30px 0; margin: 0;">{{ $classification->jumlah }}</p>
			</td>
        </tr>
    </table>
</div>
