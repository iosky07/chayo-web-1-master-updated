<?php

namespace App\Http\Controllers\Admin;

use App\Models\Technician;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RouterosAPI;
use App\Providers\TelnetServiceProvider;
use Borisuu\Telnet\TelnetClient;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use function PHPUnit\Framework\isEmpty;

class TechnicianController extends Controller
{
    public function index()
    {
        $status = 'kosong';
        return view('pages.technician.index', [
            'technician' => Technician::class
        ], compact('status'));
    }

    public function show($username)
    {

//        dd('tes');
        $ip = '103.164.192.124';
        $user = 'Arie';
        $pass = '190701';
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pass)) {
            $identitas_active = $API->comm('/ppp/active/print');
            $identitas_secret = $API->comm('/ppp/secret/print');
//            $identitas = $API->comm('/interface/pppoe-server/secret/print');
//            $identitas = $API->comm('/interface/wireless/registration-table/print');
        } else {
            return 'Koneksi Gagal';
        }

//        dd($identitas);
        $search = $username;

        $filteredNames_active = collect($identitas_active)->filter(function ($item) use ($search) {
            // Case-insensitive search for the search term within the name
            return stripos($item['name'], $search) !== false;
        });
        $filteredNames_secret = collect($identitas_secret)->filter(function ($item) use ($search) {
            // Case-insensitive search for the search term within the name
            return stripos($item['name'], $search) !== false;
        });
        $result_active = $filteredNames_active->values()->toArray();
        $result_secret = $filteredNames_secret->values()->toArray();
//        dd($result_active[1]['name']);
//        dd($result_secret);
        if ($result_secret) {
            $status = 'ada';
//            dd($status);

            $loop_count = 0;
            //Menjadikan format uptime menjadi Minggu hari Jam Menit Detik
            foreach ($result_secret as $item) {
                if (isEmpty($result_active)) {
                    $result_secret[$loop_count]['uptime'] = "-";
                }
                foreach ($result_active as $item_a) {
//                    dd($item['name'], $item_a['name']);
                    if ($item['name'] == $item_a['name']) {
//                        dd($item_a['name']);
                        $parts = explode(' ', $item_a['uptime']);
//                        dd($loop_count);

                        $days = 0;
                        $hours = 0;
                        $minutes = 0;
                        $seconds = 0;
                        $value = '';

                        foreach (str_split($parts[0]) as $part) {
                            if (is_numeric($part)) {
                                $value .= $part;
                            }

                            switch ($part) {
                                case 'w':
                                    $days += $value * 7;
                                    $value = 0;
                                case 'd':
                                    $days += $value;
                                    $value = 0;
                                case 'h':
                                    $hours += $value;
                                    $value = 0;
                                case 'm':
                                    $minutes += $value;
                                    $value = 0;
                                case 's':
                                    $seconds += $value;
                                    $value = 0;

                            }
                        }
                        $result_secret[$loop_count]['uptime'] = "$days Hari $hours jam $minutes menit $seconds detik";
//                        $result_secret[$loop_count]['status'] = "Working";
//                      dd($item['uptime']);
                        break;
                    }
                }

                $loop_count += 1;
//                dd($loop_count);
            }

            $inactive_user = array();
            foreach ($result_secret as $item) {
                if (count($item) < 16) {
                    $inactive_user[] = $item;
                }
            }
//            dd($inactive_user);
            #######################################################
            $port = 62234;
            $host = '103.164.192.124';
            $username = 'admin';
            $password = 'admin1234!';
            $debug = 0;
            $prompt = '#';
            $cmdList = array();
            foreach ($inactive_user as $item) {
                $cmdList[] = 'show gpon onu by sn ' . $item['password'];
            }

            TelnetClient::setDebug($debug > 0);

            $telnet = new TelnetClient($host, $port);

            if ($telnet->connect()) {
                $telnet->setRegexPrompt($prompt);
                $telnet->setPruneCtrlSeq(true);
                $telnet->login($username, $password);
                $PAGER_LINE = ' --More--';
                $array = [];
                $array_result = [];
                $array_result_2 = [];

                foreach (range(1, 3) as $i) {
                    foreach ($cmdList as $cmd) {
                        $telnet->sendCommand($cmd);
//            dd($telnet);
                        do {
                            $line = $telnet->getLine($matchesPrompt);
                            if (strncmp($line, $PAGER_LINE, strlen($PAGER_LINE)) === 0) {
//                    dd('tes');
                                $telnet->sendCommand(' ', false);
                            } else {
                                if (!$matchesPrompt && strncmp($line, $cmd, strlen($cmd)) === 0) {
                                    $matchesPrompt = $telnet->matchesPrompt(substr($line, strlen($cmd)));

                                    //Cosmetic, just so the next command doesn't appear on the same line
                                    $line .= "\n";
                                }
                                if ($i == 1) {
                                    array_push($array, $line);
                                } elseif ($i == 2) {
                                    array_push($array_result, $line);
                                } elseif ($i == 3) {
                                    array_push($array_result_2, $line);
                                }

//                    print($line);
                            }
                        } while (!$matchesPrompt);
                    }
//                dd($array);
                    if ($i == 1) {
                        $range_result = count($array) / 5;
                        $gpon_onu_list = array();
                        $cmdList = array();
                        $temp_num = 0;
                        foreach (range(1, $range_result) as $j) {
                            $gpon_onu_list[] = rtrim($array[3 + $temp_num], "\n");
                            $cmdList[] = 'show pon power attenuation ' . rtrim($array[3 + $temp_num], "\n");
                            $temp_num += 5;
                        }
                        $cmdList = array_unique($cmdList);
                    } elseif ($i == 2) {
                        $range_result = count($array) / 5;
                        $gpon_onu_list = array();
                        $cmdList = array();
                        $temp_num = 0;
                        foreach (range(1, $range_result) as $j) {
                            $gpon_onu_list[] = rtrim($array[3 + $temp_num], "\n");
                            $cmdList[] = 'show gpon onu state ' . str_replace('gpon-onu', 'gpon-olt', substr($array[3 + $temp_num], 0, strrpos($array[3 + $temp_num], ':')));
                            $temp_num += 5;
                        }

                        $cmdList = array_unique($cmdList);
                    }

                }
//                dd($array_result);
//            dd(substr($array_result[5], 34, 12));
//            dd(substr(ltrim($array_result_2[252], "\x08 "), -15));
//                $temp_num = 7;
                foreach (range(0, count($gpon_onu_list) - 1) as $i) {
//                    dd($i);
                    foreach ($array_result_2 as $item) {

                        $number = '';
                        $str_len = strlen($gpon_onu_list[$i]);
//                        dd($gpon_onu_list[$i]);
                        // Iterasi dari indeks 13 ke depan untuk mencari angka
                        for ($h = 13; $h < $str_len; $h++) {
                            $char = $gpon_onu_list[$i][$h];

                            // Jika karakter bertemu ':', hentikan iterasi
                            if ($char === ':') {
                                break;
                            }

                            // Jika karakter adalah angka, tambahkan ke string angka
                            if (is_numeric($char)) {
                                $number .= $char;
                            }
                        }
//                        dd($array_result);
                        $result_secret[$i]['port'] = $number;
                        $temp_num = 7 * ($i);
                        $result_secret[$i]['optic-score'] = substr($array_result[5 + $temp_num], 34, 12);

                        if (substr(ltrim($item, "\x08 "), 0, $str_len) == $gpon_onu_list[$i]) {
//                            dd($gpon_onu_list[$i]);
                            if (Str::contains(ltrim($item, "\x08 "), 'DyingGasp')) {
                                $result_secret[$i]['status'] = 'DyingGasp';
                            } elseif (Str::contains(ltrim($item, "\x08 "), 'OffLine')) {
                                $result_secret[$i]['status'] = 'Offline';
                            } elseif (Str::contains(ltrim($item, "\x08 "), 'LOS')) {
                                $result_secret[$i]['status'] = 'LOS';
                            } elseif (Str::contains(ltrim($item, "\x08 "), 'syncMib')) {
                                $result_secret[$i]['status'] = 'syncMib';
                            } elseif (Str::contains(ltrim($item, "\x08 "), 'working')) {
                                $result_secret[$i]['status'] = 'Working';
                            }
                            break;
                        }
                    }
                }
//                dd($result_secret);
                $telnet->disconnect();
            } else {
                return "Koneksi Gagal, coba refresh lagi. Jika masih tidak bisa silahkan hubungi Admin";
            }
            #######################################################
        } else {
            $status = 'kosong';
        }
//        dd($status);

        return view('pages.technician.index', [
            'technician' => Technician::class
        ], compact('result_secret', 'status'));
    }

    public function olt_user_offline()
    {

        $ip = '103.164.192.124';
        $user = 'Arie';
        $pass = '190701';
        $API = new RouterosAPI();
        $API->debug('false');

//        $telnet = new TelnetClient($ip, 62234);
//        $telnet->connect();
//        $telnet->setPrompt('#'); //setRegexPrompt() to use a regex
//        $telnet->login('admin', 'admin1234!');
//
//        $sn = 'RTEGCA988DAB';
////        $onu = $telnet->exec('show gpon onu by sn '.$sn);
////        dd('show pon power att '.$onu[3]);
////        $cmdResult = $telnet->exec('show pon power att '.$onu[3]);
//        $cmdResult = $telnet->exec('show gpon onu state gpon-olt_1/1/14');
//        dd($cmdResult);
//        dd($onu[3], Str::substr($cmdResult[7], 0, 17));
//        foreach ($cmdResult as $item) {
//            $len_value = strlen($onu[3]);
//            if ($onu[3] == Str::substr($item, 0, $len_value)) {
//                dd($item);
//            }
//        }
//
//        dd($cmdResult);
//
//        $telnet->disconnect();

//        dd(substr($cmdResult[5], 34, 12));

        if ($API->connect($ip, $user, $pass)) {
            $user_on = $API->comm('/ppp/secret/print', array('?disabled' => 'no'));
            $user_active_on = $API->comm('/ppp/active/print');
            //$user_interface_port = $API->comm('/interface/pppoe-server/print');
        } else {
            return 'Koneksi Gagal';
        }
//        dd($user_on)
//        $key = 'indah-tri-lestari@chayo.net';
//        $user_on = array_get($user_on, $key);
        $notFoundData = [];
        foreach ($user_on as $uo) {
            $found = false;
            foreach ($user_active_on as $uao) {
                if ($uo['name'] === $uao['name']) {
                    $found = true;
                    break;
                }
            }
//            dd($uo['name'], $uao['name']);
            $today = Carbon::now();
            if ($found == false) {
                $target_date = Carbon::createFromFormat('M/d/Y H:i:s', $uo['last-logged-out']);
                $diff_days = $today->diffInDays($target_date);
//                dd($diff_days);
                if ($diff_days < 3) {
                    if ($uo['service'] == 'pppoe') {
                        #nanti tambahin info port pake data di db
                        $notFoundData[] = $uo;
                    }
                }
            }
        }

//        dd($notFoundData);
        #######################################################
        $port = 62234;
        $host = '103.164.192.124';
        $username = 'admin';
        $password = 'admin1234!';
        $debug = 0;
        $prompt = '#';
        $cmdList = array();
        foreach ($notFoundData as $item) {
            $cmdList[] = 'show gpon onu by sn ' . $item['password'];
        }
//        dd($cmdList);

        TelnetClient::setDebug($debug > 0);

        $telnet = new TelnetClient($host, $port);
        if ($telnet->connect()) {
            $telnet->setRegexPrompt($prompt);
            $telnet->setPruneCtrlSeq(true);
            $telnet->login($username, $password);
            $PAGER_LINE = ' --More--';
            $array = [];
            $array_result = [];

            foreach (range(1, 2) as $i) {
                foreach ($cmdList as $cmd) {
                    $telnet->sendCommand($cmd);
//            dd($telnet);
                    do {
                        $line = $telnet->getLine($matchesPrompt);
                        if (strncmp($line, $PAGER_LINE, strlen($PAGER_LINE)) === 0) {
//                    dd('tes');
                            $telnet->sendCommand(' ', false);
                        } else {
                            if (!$matchesPrompt && strncmp($line, $cmd, strlen($cmd)) === 0) {
                                $matchesPrompt = $telnet->matchesPrompt(substr($line, strlen($cmd)));

                                //Cosmetic, just so the next command doesn't appear on the same line
                                $line .= "\n";
                            }
                            if ($i == 1) {
                                array_push($array, $line);
                            } elseif ($i == 2) {
                                array_push($array_result, $line);
                            }

//                    print($line);
                        }
                    } while (!$matchesPrompt);
                }
//            dd($array);
                $range_result = count($array) / 5;
                $gpon_onu_list = array();
                $cmdList = array();
                $temp_num = 0;
                foreach (range(1, $range_result) as $j) {
                    $gpon_onu_list[] = rtrim($array[3 + $temp_num], "\n");
                    $cmdList[] = 'show gpon onu state ' . str_replace('gpon-onu', 'gpon-olt', substr($array[3 + $temp_num], 0, strrpos($array[3 + $temp_num], ':')));
                    $temp_num += 5;
                }
//            dd($gpon_onu_list[0][13]);
                $cmdList = array_unique($cmdList);
            }

//            $temp_num = 0;
            foreach (range(0, count($gpon_onu_list) - 1) as $i) {

                foreach ($array_result as $item) {

                    $number = '';
                    $str_len = strlen($gpon_onu_list[$i]);
//                        dd($gpon_onu_list[$i]);
                    // Iterasi dari indeks 13 ke depan untuk mencari angka
                    for ($h = 13; $h < $str_len; $h++) {
                        $char = $gpon_onu_list[$i][$h];

                        // Jika karakter bertemu ':', hentikan iterasi
                        if ($char === ':') {
                            break;
                        }

                        // Jika karakter adalah angka, tambahkan ke string angka
                        if (is_numeric($char)) {
                            $number .= $char;
                        }
                    }
//                        dd($array_result);
                    $notFoundData[$i]['port'] = $number;
//                    $temp_num = 7 * ($i);

                    foreach ($array_result as $item) {
                        $str_len = strlen($gpon_onu_list[$i]);
                        if (substr(ltrim($item, "\x08 "), 0, $str_len) == $gpon_onu_list[$i]) {
//                            dd($gpon_onu_list[$i]);
                            if (Str::contains(ltrim($item, "\x08 "), 'DyingGasp')) {
                                $notFoundData[$i]['status'] = 'DyingGasp';
                            } elseif (Str::contains(ltrim($item, "\x08 "), 'OffLine')) {
                                $notFoundData[$i]['status'] = 'Offline';
                            } elseif (Str::contains(ltrim($item, "\x08 "), 'LOS')) {
                                $notFoundData[$i]['status'] = 'LOS';
                            } elseif (Str::contains(ltrim($item, "\x08 "), 'syncMib')) {
                                $notFoundData[$i]['status'] = 'syncMib';
                            } elseif (Str::contains(ltrim($item, "\x08 "), 'working')) {
                                $notFoundData[$i]['status'] = 'Working';
                            }
                            break;
                        }
                    }
                }
//                dd($notFoundData);
//          dd(substr($array_result[23], -8));

                $telnet->disconnect();
            }
            #######################################################

            return view('pages.technician.olt_user_offline', [
                'technician' => Technician::class
            ], compact('notFoundData'));
        }
    }
}
