<header>
    <div class="block row">
        <div class="col-md-4" style="float: right">
            @if ($patient)
                <table class="table small no-border ">
                    <tbody>
                    <tr class="">
                        <td width="75px;" style="vertical-align:top">First name:</td>
                        <td>
                            {{ $patient->first_name }}
                        </td>
                    </tr>
                    <tr class="">
                        <td width="75px;" style="vertical-align:top">Last name:</td>
                        <td>
                            {{ $patient->last_name }}
                        </td>
                    </tr>
                    <tr class="">
                        <td width="75px;" style="vertical-align:top">DOB:</td>
                        <td>
                            {{ $patient->dob !== null ? $patient->dob->format('m/d/Y') : '' }}
                        </td>
                    </tr>
                </table>
            @endif

        </div>
        <div class="col-md-8">
            <div class="small text-left">
                <img src="{{ public_path('images/dhc-black.png') }}" width="160px">
            </div>
        </div>

    </div>
    <div class="block row">
        <div class="col-md-12">
            <h3 class="text-center">{{$title}}</h3>
            @if($subtitle)
                <div class="text-center">{{$subtitle}}</div>
            @endif
        </div>
    </div>
</header>
