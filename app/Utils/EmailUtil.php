<?php
declare (strict_types=1);

namespace App\Utils;


use PHPMailer\PHPMailer\PHPMailer;

class EmailUtil
{
    /**
     * 发送邮件
     * @param array $config
     * @param string $nickname
     * @param string $card
     * @param string $shopName
     * @param string $email
     * @return bool
     */
    public static function send(array $config, string $nickname, string $card, string $shopName, string $email): bool
    {
        try {
            $mail = new PHPMailer(); //PHPMailer对象
            $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
            $mail->IsSMTP(); // 设定使用SMTP服务
            $mail->SMTPDebug = 0; // 关闭SMTP调试功能
            $mail->SMTPAuth = true; // 启用 SMTP 验证功能
            $mail->SMTPSecure = 'ssl'; // 使用安全协议
            $mail->Host = $config['smtp']; // SMTP 服务器
            $mail->Port = $config['port']; // SMTP服务器的端口号
            $mail->Username = $config['user']; // SMTP服务器用户名
            $mail->Password = $config['pass']; // SMTP服务器密码
            $mail->SetFrom($config['user'], $nickname); // 邮箱，昵称
            $mail->AddAddress($email);
            $mail->Subject = $shopName . "-发货通知";
            $mail->MsgHTML(str_replace(PHP_EOL, '<br>', "您好，您本次购买的卡密信息是：\n" . $card));

            $result = $mail->Send();

            if (!$result) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}