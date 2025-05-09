<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'rocking_money'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'insert_date' => $_POST['insert_date'],
  'amount' => $_POST['amount'],
  'remark' => $_POST['remark'],
  'status' => $_POST['status'],
  'transaction_from_bank_no' => $_POST['transaction_from_bank_no'],
  'transaction_to_bank_no' => $_POST['transaction_to_bank_no'],
];
if ($_POST['status'] == 'all') {
  unset($where['status']);
}
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];

$data_list = nga_management_bot::selectBotTransferMoney($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php
  foreach ($list as $trans_money) {

    if ($trans_money['transaction_from_bank_abb'] == 'SCB') {
      $remark_cancel = json_decode(str_replace('bot complete remark->', '', $trans_money['remark_cancel']), true);
      $qr_string = ($remark_cancel) ? $remark_cancel['data']['additionalMetaData']['paymentInfo'][0]['QRstring'] : '';
    } else if ($trans_money['transaction_from_bank_abb'] == 'KBANK') {
      $remark_cancel = json_decode(str_replace('bot complete remark->', '', $trans_money['remark_cancel']), true);
      $qr_string = ($remark_cancel) ? $remark_cancel[0]['rawQr'] : '';
    } else {
      $qr_string = '';
    }
    $img_qr_code = ($qr_string) ? 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $qr_string . '&choe=UTF-8' : '';

    $trans_money['date_data'] = Aww::formatDate($trans_money['insert_date_time'], 'd/m/Y, H:i');
    $trans_money['amount_format'] = number_format($trans_money['amount'], 2);
    $trans_money['account_web'] = $trans_money['transaction_from_bank_name'];
    $trans_money['account_web2'] = $trans_money['transaction_from_bank_no'];
    $trans_money['account_web3'] = $trans_money['transaction_from_bank_name_th'];
    $trans_money['confirm_date'] = isset($trans_money['confirm_date_time']) ? Aww::formatDate($trans_money['confirm_date_time'], 'd/m/Y, H:i') : '';
    $trans_money['img_transfer'] = ($trans_money['status'] == 'confirm') ? 'assets/image/bot-auto.png' : '';
    $trans_money['img_qr_code'] = $img_qr_code;
    if (isset($trans_money['confirm_date_time']) && $trans_money['status'] == 'confirm') {
      $trans_money['transfer_status'] = 'โอนเงินแล้ว';
    } else if ($trans_money['status'] == 'wait_confirm') {
      $trans_money['transfer_status'] = 'รอดำเนินการ';
    } else if ($trans_money['status'] == 'cancel') {
      $trans_money['transfer_status'] = 'ยกเลิก';
    }
    if ($trans_money['status'] == 'wait_confirm') {
      $txt_status = 'รอดำเนินการ';
      $trans_money['waiting_txt'] = 'รอดำเนินการ';
      $trans_money['confirm_txt'] = '';
      $trans_money['cancel_txt'] = '';
    } else if ($trans_money['status'] == 'confirm') {
      $txt_status = 'ได้รับเงินแล้ว';
      $trans_money['waiting_txt'] = '';
      $trans_money['confirm_txt'] = 'ได้รับเงินแล้ว';
      $trans_money['cancel_txt'] = '';
    } else if ($trans_money['status'] == 'transfer_error') {
      $txt_status = $trans_money['transfer_error_text'];
    } else {
      $txt_status = 'ยกเลิก';
      $trans_money['waiting_txt'] = '';
      $trans_money['confirm_txt'] = '';
      $trans_money['cancel_txt'] = 'ยกเลิก';
    }
  ?>
    <tr>
      <td nowrap>
        <div class="font-16px font-Medium">
          <?= Aww::formatDate($trans_money['insert_date_time'], 'd/m/Y, H:i'); ?>
        </div>
      </td>
      <td nowrap>
        <div class="font-16px font-Regular">
          โยกเงิน
        </div>
      </td>
      <td nowrap align="right" class="font-16px font-Regular"><?= number_format($trans_money['amount'], 2); ?></td>
      <td nowrap align="right" class="font-16px font-Regular"><?= number_format($trans_money['money_before'], 2); ?></td>
      <td nowrap align="right" class="font-16px font-Regular"><?= number_format($trans_money['money_after'], 2); ?></td>
      <td nowrap><?= $trans_money['remark']; ?></td>
      <td nowrap>
        <div class="d-flex">
          <div class="bank-img small-size mr-5px">
            <img src="<?= $trans_money['transaction_to_bank_image']; ?>">
          </div>
          <div class=" d-flex flex-column">
            <div class=" text-primary">
              <?= $trans_money['transaction_to_bank_name_th']; ?>
            </div>
            <div>
              <?= $trans_money['transaction_to_bank_no']; ?>
            </div>
          </div>
        </div>
      </td>
      <td nowrap>
        <div class="d-flex">
          <div class="bank-img small-size mr-5px">
            <img src="<?= $trans_money['transaction_from_bank_image']; ?>">
          </div>
          <div class=" d-flex flex-column">
            <div>
              <?= $trans_money['transaction_from_bank_name']; ?>
            </div>
            <div>
              <?= $trans_money['transaction_from_bank_no']; ?>
            </div>
          </div>
        </div>
      </td>

      <td nowrap class="thin-cell">
        <div class="form-row pr-20px font-14px font-Medium">
          <div class="d-flex">
            <div class="mt-1px mx-10px">
              <?php if ($trans_money['status'] == 'wait_confirm') {
                echo file_get_contents("./../assets/icon/icon-dot-yellow.svg");
              } else if ($trans_money['status'] == 'confirm') {
                echo file_get_contents("./../assets/icon/icon-dot-green.svg");
              } else if ($trans_money['status'] == 'cancel') {
                echo file_get_contents("./../assets/icon/icon-dot-red.svg");
              } else if ($trans_money['status'] == 'transfer_error') {
                echo file_get_contents("./../assets/icon/icon-dot-red.svg");
              }
              ?>
            </div>
            <div class=" d-flex flex-column">
              <div class="mt-3px">
                <?= $txt_status; ?>
              </div>
              <div class="mt-3px">
                <?php if ($trans_money['status'] == 'confirm') {
                  echo 'โดย ' . $trans_money['insert_username'];
                } else if ($trans_money['status'] == 'cancel') {
                  if ($trans_money['cancel_transfer_by_username']) {
                    echo 'โดย ' . $trans_money['cancel_transfer_by_username'];
                  }
                } else if ($trans_money['status'] == 'wait_confirm') {
                  echo 'โดย ' . $trans_money['insert_username'];
                } else if ($trans_money['status'] == 'transfer_error') {
                  echo $transfer_error_text;
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </td>
      <td class="disabled-link">
        <div class="d-flex justify-content-center align-items-center">
          <button class="form-btn-icon " <?php Tiwdal::register('detail_rocking_money', $trans_money) ?>>
            <img src="assets/icon/search-hover.svg" alt="">
          </button>
          <button class="form-btn-icon " <?php Tiwdal::register('cancel_transfer_money', $trans_money) ?>>
            <img src="assets/icon/icon-cancel.svg" alt="">
          </button>
        </div>
      </td>
    </tr>
  <?php
  }
  ?>


</tbody>