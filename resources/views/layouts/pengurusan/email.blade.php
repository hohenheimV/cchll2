<style>
    @media print {
        .noprint {
            visibility: hidden;
        }
    }
</style>
<div style="width:100%;padding:24px 0 16px 0;background-color:rgba(54, 156, 0, .1);text-align:center; font-family:Arial, Helvetica, sans-serif">
    <div style="display:inline-block;width:90%;max-width:820px;min-width:280px;text-align:left;">
        <table style="padding:10px 0; width: 100%">
            <tbody>
                <tr>
                    <td style="text-transform: uppercase;width:100%;font-size:18px;color:#333;line-height:1rem;min-height:40px;vertical-align:middle; font-weight:bold">
                        <span style="color: #84cd73;">{{config('app.name')}}</span><br/>{{config('app.agency')}}
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="padding:18px;background:#fff;box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2); border-top: 3px solid #84cd73; font-size: 14px;" dir="ltr">

            <!-- Content Email -->
            <p>Assalamualaikum w.b.t. dan Salam Sejahtera,</p>
            @yield('body')

            <p style="font-size:11px;color:#646464;line-height:1rem; padding-top: 1.5rem; text-align: center" class="noprint">
                Email ini adalah dijana oleh Sistem {{config('app.name')}} untuk makluman dan tindakan selanjutnya, oleh itu email
                ini <b>tidak perlu dibalas</b>.
            </p>
        </div>

        <table style="padding:10px 10px 0 10px; width: 100%;">
            <tbody>
                <tr>
                    <td style="width:100%;font-size:11px;color:#646464;line-height:1rem;min-height:40px;vertical-align:middle; text-align: center">
                        Jika anda mempunyai sebarang masalah dengan perkhidmatan {{config('app.name')}}, sila ajukan aduan kepada<br/>
                        <b>KETUA PENGARAH, JABATAN LANDSKAP NEGARA</b>,<br />
                        Aras 10, Blok F10, Kompleks Bangunan Kerajaan Parcel F, Presint 1,<br />
                        Pusat Pentadbiran Kerajaan Persekutuan, 62000 PUTRAJAYA.<br />
                        Tel.: (603) 8091 0500 | Faks.: (603) 8091 0670 | E-mel:kpjln@jln.gov.my<br />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
