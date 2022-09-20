<?php

namespace App\Services;

use App\Models\Qxwsa;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class QxtendServices
{
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

    public function qxtfSingleItem($datas)
    {

        DB::beginTransaction();

        try {

            $qxwsa = Qxwsa::first();

            // Var Qxtend
            $qxUrl          = $qxwsa->qx_url; // Edit Here

            $qxRcv          = $qxwsa->qx_rcv;

            $timeout        = 0;

            $domain         = $qxwsa->wsas_domain;

            // XML Qextend ** Edit Here
            $qdocHead = '<?xml version="1.0" encoding="UTF-8"?>
            <soapenv:Envelope xmlns="urn:schemas-qad-com:xml-services"
              xmlns:qcom="urn:schemas-qad-com:xml-services:common"
              xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:wsa="http://www.w3.org/2005/08/addressing">
              <soapenv:Header>
                <wsa:Action/>
                <wsa:To>urn:services-qad-com:'. $qxRcv .'</wsa:To>
                <wsa:MessageID>urn:services-qad-com::'. $qxRcv .'</wsa:MessageID>
                <wsa:ReferenceParameters>
                  <qcom:suppressResponseDetail>true</qcom:suppressResponseDetail>
                </wsa:ReferenceParameters>
                <wsa:ReplyTo>
                  <wsa:Address>urn:services-qad-com:</wsa:Address>
                </wsa:ReplyTo>
              </soapenv:Header>
              <soapenv:Body>
                <transferInvSingleItem>
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
                      <qcom:propertyValue>ERP3_1</qcom:propertyValue>
                    </qcom:ttContext>
                    <qcom:ttContext>
                      <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                      <qcom:propertyName>mnemonicsRaw</qcom:propertyName>
                      <qcom:propertyValue>false</qcom:propertyValue>
                    </qcom:ttContext>
                    <!--
                    <qcom:ttContext>
                      <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                      <qcom:propertyName>username</qcom:propertyName>
                      <qcom:propertyValue/>
                    </qcom:ttContext>
                    <qcom:ttContext>
                      <qcom:propertyQualifier>QAD</qcom:propertyQualifier>
                      <qcom:propertyName>password</qcom:propertyName>
                      <qcom:propertyValue/>
                    </qcom:ttContext>
                    -->
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
                  </qcom:dsSessionContext>';


            $qdocBody = ' <dsItem>
                            <item>
                                <operation>text</operation>
                                <part>text</part>
                                <itemDetail>
                                    <operation>text</operation>
                                    <lotserialQty>999.99</lotserialQty>
                                    <effDate>2003-01-31</effDate>
                                    <nbr>text</nbr>
                                    <soJob>text</soJob>
                                    <rmks>text</rmks>
                                    <siteFrom>text</siteFrom>
                                    <locFrom>text</locFrom>
                                    <lotserFrom>text</lotserFrom>
                                    <lotrefFrom>text</lotrefFrom>
                                    <siteTo>text</siteTo>
                                    <locTo>text</locTo>
                                    <yn>true</yn>
                                    <yn1>true</yn1>
                                    <yn2>true</yn2>
                                    <lcUserid>text</lcUserid>
                                    <lcPasswd>text</lcPasswd>
                                    <lcRsnCode>text</lcRsnCode>
                                    <lcComment>text</lcComment>
                                    <llScroll>true</llScroll>';
            $qdocfooter = '</itemDetail>
                            </item>
                        </dsItem>
                    </transferInvSingleItem>
                </soapenv:Body>
            </soapenv:Envelope>';

            $qdocRequest = $qdocHead . $qdocBody . $qdocfooter;

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

            if (is_bool($qdocResponse)) {

                DB::rollBack();
                return false;
            }
            $xmlResp = simplexml_load_string($qdocResponse);
            $xmlResp->registerXPathNamespace('ns1', 'urn:schemas-qad-com:xml-services');
            $qdocResult = (string) $xmlResp->xpath('//ns1:result')[0];



            if ($qdocResult == "success" or $qdocResult == "warning") {

                DB::commit();
                return true;
            } else {

                DB::rollBack();
                return 'qxtend_err';
            }
        } catch (Exception $e) {

            DB::rollback();
            return 'db_err';
        }
    }

    //
}
