<!DOCTYPE html>
<html lang="en">
@include('pdf.patient.head')
<body>
@include('pdf.patient.header')
<main>
    @if (isset($imageContent) && !is_null($imageContent))
        <img src="data:image/jpg;base64,<?php echo $imageContent;?>" style="width: 100%; margin-bottom: 30px" />
        <br/>
    @endif

    @if (!is_null($data) && $data->count() > 0 )
        <div class="block row">
            <div class="col-md-12">
                <table class="table">
                    <thead >
                        <tr >
                            <th class="text-left" >SATURATION</th>
                            <th class="text-left" >PULSE</th>
                            <th class="text-left" style="width: 150px" >DATE</th>
                        </tr>
                        <tbody>
                        @foreach ($data as $info)
                            <tr class="">
                                <td class="text-left " style="vertical-align:top">
                                    {{ $info->saturation }}% Sp02
                                </td>
                                <td class="text-left " style="vertical-align:top">
                                    {{ $info->pulse ?? '-' }} bpm
                                </td>
                                <td class="text-left" style="vertical-align:top">
                                    {{ $info->created_at->format('m/d/Y \a\t g:i A')}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    @else
        <div class="text-center">No oxygen saturation readings.</div>
    @endif



</main>
@include('pdf.patient.footer')
</body>
</html>

