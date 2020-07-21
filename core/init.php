<?php
declare (strict_types=1);
//导入自动加载
require(BASE_PATH . '/vendor/autoload.php');
require(BASE_PATH . '/core/helper.php');
//启用session
session_start();
//应用配置
$app = \Core\Utils\Bridge::getConfig('app');

try {
    if (!isset($_GET['s'])) {
        $_GET['s'] = $app['index'];
    } elseif ($_GET['s'] == '/admin') {
        \App\Utils\LocalUtil::redirect($app['admin']);
    }

    //这里实现路由功能，规则：/文件夹/控制器/方法
    $s = explode("/", trim((string)$_GET['s'], '/'));
    $count = count($s);

    if ($count == 2) {
        //1级目录下进行
        $controller = "App\\Controller\\" . ucfirst($s[0]) . 'Controller';
        $action = $s[1];
    } else {
        $controller = "App\\Controller";
        foreach ($s as $j => $x) {
            if ($j == ($count - 1)) {
                break;
            }
            $controller .= '\\' . ucfirst($x);
        }
        $controller .= 'Controller';
        $action = end($s);
    }

    $actions = explode('@', $action);
    $action = $actions[0];
    unset($actions[0]);
    foreach ($actions as $act) {
        $query = explode('=', $act);
        $_GET[$query[0]] = $query[1];
    }


    //检测类是否存在
    if (!class_exists($controller)) {
        throw new \Core\Exception\NotFoundException("Not Found");
    }
    //初始化数据库
    $capsule = new \Illuminate\Database\Capsule\Manager();
    // 创建链接
    $capsule->addConnection(\Core\Utils\Bridge::getConfig('database'));
    // 设置全局静态可访问
    $capsule->setAsGlobal();
    // 启动Eloquent
    $capsule->bootEloquent();
    //反射控制器
    $rp = new ReflectionClass ($controller);
    //获取源代码
    $source = \Core\Utils\Bridge::getSource($rp);

    //获取拦截器
    preg_match("/@Interceptor\((.*?)::class\)/", $rp->getDocComment(), $a);
    $interceptorName = trim((string)$a[1]);
    if ($interceptorName != "") {
        //获取拦截器地址
        preg_match("/use (.*){$interceptorName};/", $source, $q);
        $namespace = trim((string)$q[1]) . $interceptorName;
        if (class_exists($namespace)) {
            //调用拦截器
            call_user_func([new $namespace, 'handle']);
        } else {
            dd("拦截器不存在");
        }
    }

    //检测属性依赖注入
    $properties = $rp->getProperties();
    //获取依赖配置
    $dependencies = \Core\Utils\Bridge::getConfig('dependencies');
    $propertyDependencies = [];
    foreach ($properties as $property) {
        preg_match('/@var(.*)+?/', $property->getDocComment(), $b);
        //拿到var
        $var = trim((string)$b[1]);
        //拿到service地址
        preg_match("/use (.*){$var};/", $source, $c);
        //拿到service的命名空间
        $namespace = trim((string)$c[1]) . $var;
        //检测接口是否存在
        if (interface_exists($namespace) && strpos($property->getDocComment(), '@Inject') !== false) {
            //进行依赖注入
            $propertyDependencies[$property->getName()] = new $dependencies[$namespace];
        }
    }

    $object = new $controller;

    if (!method_exists($object, $action)) {
        throw new \Core\Exception\NotFoundException("Not Found");
    }

    $reflectionParameters = $rp->getMethod($action)->getParameters();
    $query = [];
    foreach ($reflectionParameters as $parameter) {
        $query[] = isset($_GET[$parameter->name]) ? $_GET[$parameter->name] : $_POST[$parameter->name];
    }


    foreach ($propertyDependencies as $name => $dependency) {
        $object->$name = $dependency;
    }

    //拿到控制器， 进行注入
    $result = call_user_func_array([$object, $action], $query);

    if (!is_scalar($result)) {
        header('content-type:application/json;charset=utf-8');
        echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    } else {
        header("Content-type: text/html; charset=utf-8");
        echo $result;
    }
} catch (Throwable $e) {
    if (class_exists($app['exception'])) {
        $exception = new $app['exception'];
        if ($e instanceof \Core\Exception\NotFoundException) {
            $exception->handle($e);
        } elseif ($e instanceof \Core\Exception\JSONException) {
            header('content-type:application/json;charset=utf-8');
            $exception->handle($e);
        } elseif ($e instanceof \Core\Exception\ViewException) {
            header("Content-type: text/html; charset=utf-8");
            $exception->handle($e);
        } else {
            $exception->handle(new \Core\Exception\RuntimeException($e->getMessage()));
        }
    } else {
        throw new RuntimeException($e->getMessage(), $e->getCode(), $e->getPrevious());
    }
}