<tr>
    <td class="content">
        <h2>
            Hi <?= $name;?>,
        </h2>
        <p>
            Your request has been received to change Your Account Password. Please reset your password from below link.
        </p>
        <table>
            <tr>
                <td align="center">
                    <p>
                        <a class="button" href="<?= $this->Url->Build(['controller'=>'Users','action'=>'resetpassword',$link],['fullBase' => true])?>"> Reset Password</a>
                    </p>
                </td>
            </tr>
        </table>
        <p>
            If you are having trouble clicking the reset button, copy and paste the URL below into your browser.
        </p>
        <p><?= $this->Url->Build(['controller'=>'Users','action'=>'resetpassword',$link],['fullBase' => true]);?></p>
        <p>
            <em>
                – Thank You
            </em>
        </p>
    </td>
</tr>