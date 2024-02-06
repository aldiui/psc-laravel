<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        h3 {
            margin: 2;
        }
    </style>
    @stack('style')
</head>
</head>

<body>
    <table width="100%" border="0" cellpadding="2.5" cellspacing="0">
        <tbody>
            <tr>
                <td width='20%'>
                    <img width='120px' src="{{ generateBase64Image(public_path('images/logo-pemkot.png')) }}"
                        alt="">
                </td>
                <td align="center">
                    <h3>PEMERINTAH KOTA TASIKMALAYA </h3>
                    <h3>DINAS KESEHATAN</h3>
                    <div>
                        <span>
                            Jl. Ir. H. Juanda (Komplek Perkantoran) Telp. (0265) 342437 Fax 342437
                            KOTA TASIKMALAYA
                        </span>
                    </div>
                </td>
                <td width='20%'> </td>
            </tr>
        </tbody>
    </table>
    <hr style="height:1px;background-color:black;">
    <br>
    @yield('main')


    @stack('scripts')

</body>

</html>
