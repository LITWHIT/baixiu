<?php 
// 登录页面
// 简单登录业务逻辑用（户信息校验, 页面跳转）
// 表单状态保存（保存用户名）
// 用户状态保存（Cookie、Session）
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <!-- 补全form标签的属性, action=提交url地址为该文件本身 method=post提交方式-->
    <form class="login-wrap" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong> 用户名或密码错误！
      </div> -->
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" name="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" class="form-control" placeholder="密码">
      </div>
      <!-- form表单提交按钮的类型必须为'submit' -->
      <button class="btn btn-primary btn-block" type="submit">登 录</button>
    </form>
  </div>
</body>
</html>
