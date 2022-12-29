<?php

namespace App\Http\Controllers\SP;

use App\Http\Controllers\Controller;
use App\Services\WSAServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Qxwsa as ModelsQxwsa;
use Exception;

class KebutuhanSPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function httpHeader($req)
    {
      return array(
        'Content-type: text/xml;charset="utf-8"',
        'Accept: text/xml',
        'Cache-Control: no-cache',
        'Pragma: no-cache',
        'SOAPAction: ""',        // jika tidak pakai SOAPAction, isinya harus ada tanda petik 2 --> ""
        'Content-length: ' . strlen(preg_replace("/\s+/", " ", $req))
      );
    }

    public function index(Request $request)
    {
        $asset = DB::table('asset_mstr')
            ->orderBy('asset_code')
            ->get();

        $datawo = DB::table('wo_mstr')
            ->leftJoin('wo_dets', 'wo_dets_nbr', '=', 'wo_nbr')
            ->join('asset_mstr', 'asset_code', '=', 'wo_asset')
            ->leftjoin('sp_mstr', 'wo_dets_sp', '=', 'spm_code')
            ->where('wo_dets_sp', '<>', '')
            ->orderBy('wo_schedule');

        if ($request->s_nomorwo) {
            $datawo->where('wo_nbr', '=', $request->s_nomorwo);
        }

        if ($request->s_asset) {
            $datawo->where('asset_code', '=', $request->s_asset);
        }

        if ($request->s_priority) {
            $datawo->where('wo_priority', '=', $request->s_priority);
        }

        $datawo = $datawo->paginate(10);

        // dd($datawo);

        return view('schedule.kebutuhansp-browse', ['datawo' => $datawo, 'asset' => $asset]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\KebutuhanSP  $kebutuhanSP
     * @return \Illuminate\Http\Response
     */

    public function generateso(Request $req)
    {

        DB::beginTransaction();

        try {

            $domain = ModelsQxwsa::first();

            $checkso_eams = (new WSAServices())->wsasearchso($domain->wsas_domain);

            if ($checkso_eams === false) {
                toast('WSA Error', 'error')->persistent('Dismiss');
                return redirect()->back();
            } else {

                if ($checkso_eams[1] == "false") {
                    toast('WSA Failed', 'error')->persistent('Dismiss');
                    return redirect()->back();
                } else {

                    foreach ($checkso_eams[0] as $datas) {
                        if ($datas->t_msg == "false") {
                            dd('data tidak eksis. buat so eams');
                        } else {

                            $qxwsa = ModelsQxwsa::first();

                            // Var Qxtend
                            $qxUrl          = $qxwsa->qx_url; // Edit Here

                            $qxRcv          = $qxwsa->qx_rcv;

                            $timeout        = 0;

                            $domain         = $qxwsa->wsas_domain;

                            // XML Qextend ** Edit Here

                            // dd($qxRcv);

                            $qdocHead = '<soapenv:Envelope xmlns="urn:schemas-qad-com:xml-services"
                                    xmlns:qcom="urn:schemas-qad-com:xml-services:common"
                                    xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsa="http://www.w3.org/2005/08/addressing">
                                    <soapenv:Header>
                                        <wsa:Action/>
                                        <wsa:To>urn:services-qad-com:' . $qxRcv . '</wsa:To>
                                        <wsa:MessageID>urn:services-qad-com::' . $qxRcv . '</wsa:MessageID>
                                        <wsa:ReferenceParameters>
                                        <qcom:suppressResponseDetail>true</qcom:suppressResponseDetail>
                                        </wsa:ReferenceParameters>
                                        <wsa:ReplyTo>
                                        <wsa:Address>urn:services-qad-com:</wsa:Address>
                                        </wsa:ReplyTo>
                                    </soapenv:Header>
                                    <soapenv:Body>
                                        <maintainSalesOrder>
                                        <qcom:dsSessionContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>domain</qcom:propertyName>
                                            <qcom:propertyValue>' . $domain . '</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>scopeTransaction</qcom:propertyName>
                                            <qcom:propertyValue>false</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>version</qcom:propertyName>
                                            <qcom:propertyValue>ERP3_3</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>mnemonicsRaw</qcom:propertyName>
                                            <qcom:propertyValue>false</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>username</qcom:propertyName>
                                            <qcom:propertyValue>mfg</qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>password</qcom:propertyName>
                                            <qcom:propertyValue></qcom:propertyValue>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>action</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>entity</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>email</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                            <qcom:ttContext>
                                            <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                                            <qcom:propertyName>emailLevel</qcom:propertyName>
                                            <qcom:propertyValue/>
                                            </qcom:ttContext>
                                        </qcom:dsSessionContext>
                                        <dsSalesOrder>';

                            $qdocBody = '';

                            $qdocBody .= '<salesOrder>
                                            <operation>R</operation>
                                            <soNbr>EAMS</soNbr>
                                        </salesOrder>';

                            $qdocfooter =   '</dsSalesOrder>
                                            </maintainSalesOrder>
                                        </soapenv:Body>
                                    </soapenv:Envelope>';

                            $qdocRequest = $qdocHead . $qdocBody . $qdocfooter;

                            // dd($qdocRequest);

                            $curlOptions = array(
                                CURLOPT_URL => $qxUrl,
                                CURLOPT_CONNECTTIMEOUT => $timeout,        // in seconds, 0 = unlimited / wait indefinitely.
                                CURLOPT_TIMEOUT => $timeout + 120, // The maximum number of seconds to allow cURL functions to execute. must be greater than CURLOPT_CONNECTTIMEOUT
                                CURLOPT_HTTPHEADER => $this->httpHeader($qdocRequest),
                                CURLOPT_POSTFIELDS => preg_replace("/\s+/", " ", $qdocRequest),
                                CURLOPT_POST => true,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_SSL_VERIFYPEER => false,
                                CURLOPT_SSL_VERIFYHOST => false
                            );

                            $getInfo = '';
                            $httpCode = 0;
                            $curlErrno = 0;
                            $curlError = '';


                            $qdocResponse = '';

                            $curl = curl_init();
                            if ($curl) {
                                curl_setopt_array($curl, $curlOptions);
                                $qdocResponse = curl_exec($curl);           // sending qdocRequest here, the result is qdocResponse.
                                //
                                $curlErrno = curl_errno($curl);
                                $curlError = curl_error($curl);
                                $first = true;
                                foreach (curl_getinfo($curl) as $key => $value) {
                                    if (gettype($value) != 'array') {
                                        if (!$first) $getInfo .= ", ";
                                        $getInfo = $getInfo . $key . '=>' . $value;
                                        $first = false;
                                        if ($key == 'http_code') $httpCode = $value;
                                    }
                                }
                                curl_close($curl);
                            }

                            // dd($qdocResponse);

                            if (is_bool($qdocResponse)) {

                                DB::rollBack();
                                toast('Something Wrong with Qxtend', 'error');
                                return redirect()->back();
                            }
                            $xmlResp = simplexml_load_string($qdocResponse);
                            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
                            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];



                            if ($qdocResult == "success" or $qdocResult == "warning") {
                                DB::commit();
                                toast('Delete SO EAMS Successfully', 'success');
                                return redirect()->back();
                            } else {
                                DB::rollBack();
                                toast('Delete SO EAMS Error', 'error');
                                return redirect()->back();
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            toast('Transaction Error', 'error');
            return redirect()->back();
        }
    }
}
