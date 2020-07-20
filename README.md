<p align="center"><img src="https://lizhime.com/wp-content/uploads/2020/07/%E5%B0%81%E9%9D%A2.png" width="600"></p>

<p align="center">
<a href="https://lizhime.com/41.html"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://lizhime.com/41.html"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://lizhime.com/41.html"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## 快速体验
- 后台演示：[https://faka.demo.10.do/admin](https://faka.demo.10.do/admin)  账号：admin 密码：123456
- 前台演示：[https://faka.demo.10.do](https://faka.demo.10.do)

## 关于荔枝发卡系统

荔枝发卡系统乃博主历尽数天开发完成，原生php开发，数据库底层使用`Eloquent ORM`组件，模板渲染使用`Smarty3.1`组件，会话保持使用`session`开发，欢迎各位欧尼酱使用以及转载。

- 云更新，为了去掉繁琐的后续版本更新又要下载又要升级数据库等等琐事，所以本程序实现了自动更新，一旦出现新版本，后台只需要点击按钮即可自动完成程序的所有无缝升级。
- 基础功能，卡密销售，后台添加商品，然后导入卡密，进行售卡。
- 批发优惠功能，商品中可开启批发优惠功能，以及编写优惠规则，客户一次性购买达到规定数量则会进行优惠。
- 支付对接，为了满足所有人的需求，让用户自己对接支付平台是不现实的，所以支付对接请交给作者，如果你想接入其他支付平台，你只需要将需求提交给作者，作者会在2小时内完成对接，届时，你只需要在后台添加新的支付方式就可以立即使用。
- 界面优化，完美支持PC和手机，真正的内外二次元文化。
- 还有更多强大的功能，需要安装自己发掘。至此，介绍完毕。

## 程序安装教程

- 在安装之前，请检查你的系统环境，php>=7.2，MySQL版本>=5.6，如果你满足这两个条件，表示你已经具备了安装条件。
- 将源码下载至你的服务器，然后执行`composer install`安装依赖组件。
- 以上步骤完成后，然后配置伪静态，Apache无需配置，根目录已经有.htaccess文件了，但如果你是Nginx，则需要配置伪静态。
- 下面是Nginx伪静态规则：
```
location / {
      if (!-e $request_filename){
              rewrite ^(.*)$ /index.php?s=$1 last; break;
      }
}
```
- 配置完成后，访问你的首页，即可开始安装。
- 安装完成后，后台地址是：`https://你的域名/admin`
## 版本更新记录
<p>所有更新都支持手动升级，如果你当前版本并不是最新版本的上个版本，那么你必须依次按照版本进行手动升级，直到最新版本为止。</p>
<p style="color: red;">手动升级方法：下载升级包后，有两个文件夹，file文件夹里的文件复制到根目录覆盖替换即可，sql文件夹里面的update.sql如果有内容，表示这个版本需要更新数据库某些地方，需要你手动复制到你的数据库执行一次。</p>

- 2020/07/20：增加前台统计功能，在“网站设置”启用，手动升级包：[1.3.1.zip](https://version.10.do/faka/update/1.3.1.zip)
- 2020/07/20：增加手动发卡后的自定义提示，优化前台界面购买逻辑，如改了数量或优惠卷自动显示需支付价格，手动升级包：[1.3.0.zip](https://version.10.do/faka/update/1.3.0.zip)
- 2020/07/20：紧急修复支付成功后的发卡的bug，手动升级包：[1.2.2.zip](https://version.10.do/faka/update/1.2.2.zip)
- 2020/07/20：修复https下单时，域名后面多了个443端口号，手动升级包：[1.2.1.zip](https://version.10.do/faka/update/1.2.1.zip)
- 2020/07/19：增加手动发卡和自动发卡功能，增加邮件通知功能，手动升级包：[1.2.0.zip](https://version.10.do/faka/update/1.2.0.zip)
- 2020/07/19：修复下单时，程序无法打开支付页面问题，手动升级包：[1.1.1.zip](https://version.10.do/faka/update/1.1.1.zip)
- 2020/07/19：发布1.1.0版本，大更新，添加/修改商品增加新功能“扩展信息”功能，手动升级包：[1.1.0.zip](https://version.10.do/faka/update/1.1.0.zip)
- 2020/07/18：更新1.0.1版本，BUG修复，修复拦截器没有成功注入，手动升级包：[1.0.1.zip](https://version.10.do/faka/update/1.0.1.zip)
- 2020/07/17：发布1.0.0版本。
## 更多支持
- 交流QQ群：1142236180
- 荔枝博客：https://lizhime.com