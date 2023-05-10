<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use PDF;
use App;

class EmailScheduleJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $wo;
    protected $asset;
    protected $a;
    protected $tampungarray;
    protected $requestor;
    protected $srnumber;
    protected $rejectnote;

    public function __construct($wo, $asset, $a, $tampungarray, $requestor, $srnumber, $rejectnote)
    {
        //
        $this->wo = $wo;
        $this->asset = $asset;
        $this->a = $a;
        $this->tampungarray = $tampungarray;
        $this->requestor = $requestor;
        $this->srnumber = $srnumber;
        $this->rejectnote = $rejectnote;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $wo = $this->wo;
        $asset = $this->asset;
        $a = $this->a;

        // dd($tampungarray);

        if ($a == 2) { //kirim email ke semua enjiner yg dipilih pada saat approve service request & kirim email ke requestor bahwa service requestnya assigned
            $tampungarray = $this->tampungarray;
            // dd($tampungarray);
            $countarray1 = count($tampungarray);
            $requestor = $this->requestor;
            $srnumber = $this->srnumber;
            $rejectnote = $this->rejectnote;

            $list2 = [];


            for ($i = 0; $i < $countarray1; $i++) {
                $email2 = DB::table('eng_mstr')
                    ->where('eng_code', '=', $tampungarray[$i])
                    ->first();
                $list2[$i] = $email2->eng_email;
            }

            Mail::send(
                'emailwo',
                [
                    'pesan' => 'Notifikasi New Work Order',
                    'note1' => $wo,
                    'note2' => $asset,
                    'header1' => 'WO Number'
                ],
                function ($message) use ($wo, $list2) {
                    $message->subject('eAMS - New Work Order');
                    // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                    $message->to(array_filter($list2));
                }
            );

            for ($x = 0; $x < $countarray1; $x++) {
                $email2 = DB::table('eng_mstr')
                    ->join('users', 'eng_mstr.eng_code', '=', 'users.username')
                    ->where('eng_code', '=', $tampungarray[$x])
                    ->first();

                $user = App\User::where('id', '=', $email2->id)->first();
                $details = [
                    'body' => 'There is New WO for you',
                    'url' => 'wojoblist',
                    'nbr' => $wo,
                    'note' => 'Please Check'

                ]; // isi data yang dioper


                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel

            }


            $emailrequestor = DB::table('users')
                ->where('username', '=', $requestor)
                ->first();


            Mail::send(
                'emailrequestor',
                [
                    'pesan' => 'Notifikasi Service Request Assigned to Work Order',
                    'note1' => $srnumber,
                    'note2' => $asset,
                    'header1' => 'SR Number'
                ],
                function ($message) use ($emailrequestor) {
                    $message->subject('eAMS - Service Request Assigned to Work Order');
                    // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                    $message->to($emailrequestor->email_user);
                }
            );

            $user = App\User::where('id', '=', $emailrequestor->id)->first();
            $details = [
                'body' => 'Service Request Assigned to Work Order',
                'url' => 'srbrowse',
                'nbr' => $srnumber,
                'note' => 'Please Check'

            ]; // isi data yang dioper


            $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel



            // dd($list2);
        } else if ($a == 3) { //kirim email ke department/engineer approval ketika user submit service request
            $srnumber = $this->srnumber;
            // dd($srnumber);

            $toemail = DB::table('service_req_mstr')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                ->where('sr_number', '=', $srnumber)
                ->selectRaw('service_req_mstr.*,asset_mstr.asset_desc, service_req_mstr.created_at as reqdatetime')
                ->first();

            $srdeptapprover = DB::table('sr_approver_mstr')->where('sr_approver_dept', $toemail->sr_dept)->get();
            dd($srdeptapprover);

            //cek departemen dan role approval yg sesuai dengan user yg login
            // if (Session::get('role') <> 'ADMIN') {
            //     //jika user bukan admin
            //     $srdeptapprover = DB::table('sr_trans_approval')
            //         ->where('srta_dept_approval', $toemail->sr_dept)
            //         ->where('srta_mstr_id', $toemail->id)
            //         ->where('srta_role_approval', $user->role_user)
            //         ->first();
            // } else {
            //     //jika user adalah admin
            //     $srdeptapprover = DB::table('sr_trans_approval')
            //         ->where('srta_dept_approval', $srmstr->sr_dept)
            //         ->where('srta_mstr_id', $idsr)
            //         ->first();
            // }

            if (count($srdeptapprover) > 1) {
                //kirim email ke department approver
                $emailto = DB::table('users')
                    ->leftJoin('sr_approver_mstr', 'sr_approver_mstr.sr_approver_dept', '=', 'users.dept_user')
                    ->where([
                        'dept_user'         => $srdeptapprover[0]->sr_approver_dept,
                        'role_user'         => $srdeptapprover[0]->sr_approver_role,
                        'active'            => 'Yes',
                        'sr_approver_order' => 1,
                    ])
                    ->orderBy('sr_approver_order', 'ASC')
                    ->get();

                $emails = '';

                foreach ($emailto as $email) {
                    $emails .= $email->eng_email . ',';
                }

                $emails = substr($emails, 0, strlen($emails) - 1);
                // dd($emails);
                $array_email = explode(',', $emails);
                // dd($emailto);
                if ($emailto->count())
                    //kirim email ke kepala engineer
                    Mail::send(
                        'emailwo',
                        [
                            'pesan' => 'New Service Request',
                            'note1' => $toemail->sr_number,
                            'note2' => $toemail->sr_asset . '--' . $toemail->asset_desc,
                            'header1' => 'SR Number',
                        ],
                        //  'srnote' => $toemail->sr_note,
                        //  'requestby' => $toemail->req_by,
                        function ($message) use ($array_email) {
                            $message->subject('eAMS - New Service Request');
                            // $message->from('tyas@ptimi.co.id');
                            $message->to($array_email);
                        }
                    );

                foreach ($emailto as $approver) {
                    $user = App\User::where('id', '=', $approver->id)->first();
                    $details = [
                        'body' => 'New Service Request',
                        'url' => 'srapproval',
                        'nbr' => $srnumber,
                        'note' => 'Please check'

                    ]; // isi data yang dioper

                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                


                }
            } else {
                //kirim email ke engineer approver
                $emailto = DB::table('eng_mstr')
                    ->join('users', 'eng_mstr.eng_code', '=', 'users.username')
                    ->where('approver', '=', 1)
                    ->where('eng_active', '=', 'Yes')
                    ->where('eng_dept', '=', $toemail->sr_eng_approver)
                    ->get();
                // dd($emailto);
                $emails = '';

                foreach ($emailto as $email) {
                    $emails .= $email->eng_email . ',';
                }

                $emails = substr($emails, 0, strlen($emails) - 1);
                // dd($emails);
                $array_email = explode(',', $emails);
                // dd($array_email);
                if ($emailto->count())
                    //kirim email ke kepala engineer
                    Mail::send(
                        'emailwo',
                        [
                            'pesan' => 'New Service Request',
                            'note1' => $toemail->sr_number,
                            'note2' => $toemail->sr_asset . '--' . $toemail->asset_desc,
                            'header1' => 'SR Number',
                        ],
                        //  'srnote' => $toemail->sr_note,
                        //  'requestby' => $toemail->req_by,
                        function ($message) use ($array_email) {
                            $message->subject('eAMS - New Service Request');
                            // $message->from('tyas@ptimi.co.id');
                            $message->to($array_email);
                        }
                    );

                foreach ($emailto as $approver) {
                    $user = App\User::where('id', '=', $approver->id)->first();
                    $details = [
                        'body' => 'New Service Request',
                        'url' => 'srapproval',
                        'nbr' => $srnumber,
                        'note' => 'Please check'

                    ]; // isi data yang dioper

                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                


                }
            }

            // $approverto = DB::table('eng_mstr')
            //     ->join('users', 'eng_mstr.eng_code', '=', 'users.username')
            //     ->where('approver', '=', 1)
            //     ->where('eng_active', '=', 'Yes')
            //     ->where('eng_code', '=', $toemail->sr_approver,)
            //     ->get();


        } else if ($a == 4) { //kirim email ke requestor ketika service request ditolak/reject oleh department
            // $tampungarray = $this->tampungarray;
            // dd($tampungarray);
            // $countarray1 = count($tampungarray);
            $asset = $this->asset;
            $requestor = $this->requestor;
            $srnumber = $this->srnumber;
            // $rejectnote = $this->rejectnote;
            // dd($requestor);
            $emailrequestor = DB::table('users')
                ->where('username', '=', $requestor)
                ->first();
            // dd($emailrequestor);

            Mail::send(
                'emailrequestor',
                [
                    'pesan' => 'Service Request Rejected by Department',
                    'note1' => $srnumber,
                    'note2' => $asset,
                ],
                function ($message) use ($emailrequestor) {
                    $message->subject('eAMS - Service Request Rejected by Department');
                    // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                    $message->to($emailrequestor->email_user);
                }
            );

            $user = App\User::where('id', '=', $emailrequestor->id)->first();
            $details = [
                'body' => 'Service Request Rejected by Department',
                'url' => 'srbrowse',
                'nbr' => $srnumber,
                'note' => 'Please check'

            ]; // isi data yang dioper


            $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel

        } else if ($a == 9) { //kirim email ke requestor ketika service request ditolak/reject oleh engineer
            // $tampungarray = $this->tampungarray;
            // dd($tampungarray);
            // $countarray1 = count($tampungarray);
            $asset = $this->asset;
            $requestor = $this->requestor;
            $srnumber = $this->srnumber;
            // $rejectnote = $this->rejectnote;
            // dd($requestor);
            $emailrequestor = DB::table('users')
                ->where('username', '=', $requestor)
                ->first();
            // dd($emailrequestor);

            Mail::send(
                'emailrequestor',
                [
                    'pesan' => 'Service Request Rejected by Engineer',
                    'note1' => $srnumber,
                    'note2' => $asset,
                ],
                function ($message) use ($emailrequestor) {
                    $message->subject('eAMS - Service Request Rejected by Engineer');
                    // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                    $message->to($emailrequestor->email_user);
                }
            );

            $user = App\User::where('id', '=', $emailrequestor->id)->first();
            $details = [
                'body' => 'Service Request Rejected by Engineer',
                'url' => 'srbrowse',
                'nbr' => $srnumber,
                'note' => 'Please check'

            ]; // isi data yang dioper


            $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel

        } else if ($a == 10) { //kirim email ke department/engineer ketika service request sudah di update
            $srnumber = $this->srnumber;
            // dd($srnumber);

            $toemail = DB::table('service_req_mstr')
                ->join('asset_mstr', 'asset_mstr.asset_code', 'service_req_mstr.sr_asset')
                ->where('sr_number', '=', $srnumber)
                ->selectRaw('service_req_mstr.*,asset_mstr.asset_desc, service_req_mstr.created_at as reqdatetime')
                ->first();

            $srdeptapprover = DB::table('sr_approver_mstr')->where('sr_approver_dept', $toemail->sr_dept)->get();
            // dump($srdeptapprover);
            // dd($toemail->sr_status_approval);
            if (count($srdeptapprover) > 1 || $toemail->sr_status_approval == 'Waiting for department approval') {
                //kirim email ke department approver
                $emailto = DB::table('users')
                    ->leftJoin('sr_approver_mstr', 'sr_approver_mstr.sr_approver_dept', '=', 'users.dept_user')
                    ->where([
                        'dept_user'         => $srdeptapprover[0]->sr_approver_dept,
                        'role_user'         => $srdeptapprover[0]->sr_approver_role,
                        'active'            => 'Yes',
                        'sr_approver_order' => 1,
                    ])
                    ->orderBy('sr_approver_order', 'ASC')
                    ->get();

                $emails = '';

                foreach ($emailto as $email) {
                    $emails .= $email->email_user . ',';
                }

                $emails = substr($emails, 0, strlen($emails) - 1);
                // dd($emails);
                $array_email = explode(',', $emails);
                // dd($emailto);
                if ($emailto->count())
                    //kirim email ke kepala engineer
                    Mail::send(
                        'emailwo',
                        [
                            'pesan' => 'Service Request has been updated and waiting for department approval',
                            'note1' => $toemail->sr_number,
                            'note2' => $toemail->sr_asset . '--' . $toemail->asset_desc,
                            'header1' => 'SR Number',
                        ],
                        //  'srnote' => $toemail->sr_note,
                        //  'requestby' => $toemail->req_by,
                        function ($message) use ($array_email) {
                            $message->subject('eAMS - Service Request has been updated');
                            // $message->from('tyas@ptimi.co.id');
                            $message->to($array_email);
                        }
                    );

                foreach ($emailto as $approver) {
                    $user = App\User::where('id', '=', $approver->id)->first();
                    $details = [
                        'body' => 'Service Request has been updated',
                        'url' => 'srapproval',
                        'nbr' => $srnumber,
                        'note' => 'Please check'

                    ]; // isi data yang dioper

                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                


                }
            } elseif (count($srdeptapprover) < 1 || $toemail->sr_status_approval == 'Waiting for engineer approval') {
                //kirim email ke engineer approver
                $emailto = DB::table('eng_mstr')
                    ->join('users', 'eng_mstr.eng_code', '=', 'users.username')
                    ->where('approver', '=', 1)
                    ->where('eng_active', '=', 'Yes')
                    ->where('eng_dept', '=', $toemail->sr_eng_approver)
                    ->get();
                // dd($emailto);
                $emails = '';

                foreach ($emailto as $email) {
                    $emails .= $email->eng_email . ',';
                }

                $emails = substr($emails, 0, strlen($emails) - 1);
                // dd($emails);
                $array_email = explode(',', $emails);
                // dd($array_email);
                if ($emailto->count())
                    //kirim email ke kepala engineer
                    Mail::send(
                        'emailwo',
                        [
                            'pesan' => 'Service Request has been updated and waiting for engineer approval',
                            'note1' => $toemail->sr_number,
                            'note2' => $toemail->sr_asset . '--' . $toemail->asset_desc,
                            'header1' => 'SR Number',
                        ],
                        //  'srnote' => $toemail->sr_note,
                        //  'requestby' => $toemail->req_by,
                        function ($message) use ($array_email) {
                            $message->subject('eAMS - Service Request has been updated');
                            // $message->from('tyas@ptimi.co.id');
                            $message->to($array_email);
                        }
                    );

                foreach ($emailto as $approver) {
                    $user = App\User::where('id', '=', $approver->id)->first();
                    $details = [
                        'body' => 'Service Request has been updated and waiting for approval',
                        'url' => 'srapproval',
                        'nbr' => $srnumber,
                        'note' => 'Please check'

                    ]; // isi data yang dioper

                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                


                }
            }
        } else if ($a == 7) { //kirim email ketika service request di approved dan kirim ke approver selanjutnya
            // $tampungarray = $this->tampungarray;
            // dd($tampungarray);
            // $countarray1 = count($tampungarray);
            $asset = $this->asset;
            $requestor = $this->requestor;
            $srnumber = $this->srnumber;
            // $rejectnote = $this->rejectnote;
            // dd(1);
            $srmstr = DB::table('service_req_mstr')->where('sr_number', $srnumber)->first();

            $srtransapproval = DB::table('sr_trans_approval')
                // ->where('srta_dept_approval', $srmstr->sr_dept)
                ->where('srta_mstr_id', $srmstr->id)
                ->first();

            $nextapprover = DB::table('sr_trans_approval')->where('srta_mstr_id', $srtransapproval->srta_mstr_id)
                ->where('srta_sequence', '>', $srtransapproval->srta_sequence)
                ->first();

            $emailrequestor = DB::table('users')
                ->where('dept_user', '=', $nextapprover->srta_dept_approval)
                ->where('role_user', '=', $nextapprover->srta_role_approval)
                ->get();

            $emails = '';

            foreach ($emailrequestor as $email) {
                $emails .= $email->email_user . ',';
            }

            $emails = substr($emails, 0, strlen($emails) - 1);
            // dd($emails);
            $array_email = explode(',', $emails);
            // dd($array_email);
            Mail::send(
                'emailwo',
                [
                    'pesan' => 'Service Request Waiting For Approval',
                    'note1' => $srnumber,
                    'note2' => $asset,
                    'header1' => 'SR Number',
                ],
                function ($message) use ($array_email) {
                    $message->subject('eAMS - Service Request Waiting For Approval');
                    // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                    $message->to($array_email);
                }
            );

            foreach ($emailrequestor as $approver) {
                $user = App\User::where('id', '=', $approver->id)->first();
                $details = [
                    'body' => 'Service Request Waiting For Approval',
                    'url' => 'srapproval',
                    'nbr' => $srnumber,
                    'note' => 'Please check'

                ]; // isi data yang dioper

                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                


            }
        } else if ($a == 8) { //kirim email ke engineer approver
            // $tampungarray = $this->tampungarray;
            // dd($tampungarray);
            // $countarray1 = count($tampungarray);
            $asset = $this->asset;
            $requestor = $this->requestor;
            $srnumber = $this->srnumber;
            // $rejectnote = $this->rejectnote;
            // dd(1);
            $srmstr = DB::table('service_req_mstr')->where('sr_number', $srnumber)->first();

            $emailrequestor = DB::table('eng_mstr')
                ->join('users', 'eng_mstr.eng_code', '=', 'users.username')
                ->where('approver', '=', 1)
                ->where('eng_active', '=', 'Yes')
                ->where('eng_dept', '=', $srmstr->sr_eng_approver)
                ->get();

            $emails = '';

            foreach ($emailrequestor as $email) {
                $emails .= $email->eng_email . ',';
            }

            $emails = substr($emails, 0, strlen($emails) - 1);
            // dd($emails);
            $array_email = explode(',', $emails);
            // dd($array_email);
            Mail::send(
                'emailwo',
                [
                    'pesan' => 'Service Request Waiting For Engineer Approval',
                    'note1' => $srnumber,
                    'note2' => $asset,
                    'header1' => 'SR Number',
                ],
                function ($message) use ($array_email) {
                    $message->subject('eAMS - Service Request Waiting For Engineer Approval');
                    // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                    $message->to($array_email);
                }
            );

            foreach ($emailrequestor as $approver) {
                $user = App\User::where('id', '=', $approver->id)->first();
                $details = [
                    'body' => 'Service Request Waiting For Engineer Approval',
                    'url' => 'srapproval',
                    'nbr' => $srnumber,
                    'note' => 'Please check'

                ]; // isi data yang dioper

                $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel                


            }
        } else if ($a == 1) {
            $wo = $this->wo;
            $asset = $this->asset;
            $flag = $this->a;

            $data = DB::table('eng_mstr')
                ->join('users', 'eng_mstr.eng_code', '=', 'users.username')
                ->where('approver', '=', '1')
                ->get();


            $listto = [];
            $i = 0;
            if ($data->count() > 0) {

                foreach ($data as $data1) {
                    $listto[$i] = $data1->eng_email;
                    $i++;
                }

                // Kirim Email
                Mail::send(
                    'emailwo',
                    [
                        'pesan' => 'Notifikasi New Work Order',
                        'note1' => $wo,
                        'note2' => $asset,
                        'header1' => 'Work Order'
                    ],
                    function ($message) use ($wo, $listto) {
                        $message->subject('eAMS - New Work Order');
                        // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                        $message->to(array_filter($listto));
                    }
                );


                foreach ($data as $data) {
                    $user = App\User::where('id', '=', $data->id)->first();
                    $details = [
                        'body' => 'There is new WO for you',
                        'url' => 'wobrowse',
                        'nbr' => $wo,
                        'note' => 'Please check'

                    ]; // isi data yang dioper


                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel
                }
            }
        } else if ($a == 5) {
            $wo = $this->wo;
            $asset = $this->asset;
            $flag = $this->a;

            $data = DB::table('eng_mstr')
                ->join('users', 'eng_mstr.eng_code', '=', 'users.username')
                ->where('approver', '=', '1')
                ->get();


            $listto = [];
            $i = 0;
            if ($data->count() > 0) {

                foreach ($data as $data1) {
                    $listto[$i] = $data1->eng_email;
                    $i++;
                }

                // Kirim Email
                Mail::send(
                    'emailwo',
                    [
                        'pesan' => 'Notifikasi New Work Order Direct',
                        'note1' => $wo,
                        'note2' => $asset,
                        'header1' => 'Work Order'
                    ],
                    function ($message) use ($wo, $listto) {
                        $message->subject('eAMS - New Work Order Direct');
                        // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                        $message->to(array_filter($listto));
                    }
                );


                foreach ($data as $data) {
                    $user = App\User::where('id', '=', $data->id)->first();
                    $details = [
                        'body' => 'There is new WO that created directly',
                        'url' => 'wobrowse',
                        'nbr' => $wo,
                        'note' => 'Please check'

                    ]; // isi data yang dioper


                    $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel
                }
            }
        } else if ($a == 6) { //kirim email ke user ketika reviewer WO diapprove atau reject
            $nomorwo = $this->wo;
            $srnumber =  $this->srnumber;

            $emailuser = DB::table('service_req_mstr')
                ->join('users', 'username', 'req_username')
                ->where('sr_number', '=', $srnumber)
                ->first();

            Mail::send(
                'emailrequestor',
                [
                    'pesan' => 'Service Request Rejected',
                    'note1' => $srnumber,
                    'note2' => $nomorwo,
                    'header1' => 'Work Order'
                ],
                function ($message) use ($emailuser) {
                    $message->subject('eAMS - Service Request Rejected');
                    // $message->from('andrew@ptimi.co.id'); // Email Admin Fix
                    $message->to($emailuser->email_user);
                }
            );
            //dd('tyas');
            $user = App\User::where('id', '=', $emailuser->id)->first();
            $details = [
                'body' => 'Service Request Rejected',
                'url' => 'srbrowse',
                'nbr' => $srnumber,
                'note' => 'Please check'

            ]; // isi data yang dioper


            $user->notify(new \App\Notifications\eventNotification($details)); // syntax laravel

        }
    }
}
