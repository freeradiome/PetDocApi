<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>API接口例</title>
</head>

<body>
<h1>API测试连接</h1>
<a href="./index.php?class=version&method=info" target="_blank">API版本</a><br />
<hr />
<a href="./index.php?class=tag&method=tags_cat_list&debug" target="_blank" style="color:red">症状分类</a><br />
<a href="./index.php?class=tag&method=tags_list&id=21&debug" target="_blank"  style="color:red">症状列表</a><br />
<a href="./index.php?class=illness&method=type_list&id=21&debug" target="_blank">疾病分类</a><br />
<a href="./index.php?class=illness&method=lists&id=5&debug" target="_blank">疾病列表</a><br />
<a href="./index.php?class=illness&method=detail&id=5&debug" target="_blank">疾病详情</a><br />
<hr />
<a href="./index.php?class=illness&method=lists&word=<?php echo urlencode('体重无故增加')?>&debug" target="_blank">查询</a><br />
<a href="./index.php?class=illness&method=lists&word=<?php echo urlencode('outu')?>&debug" target="_blank">同义词查询</a><br />
<hr />
<a href="./index.php?class=history&method=touch&word=<?php echo urlencode('体温宋丹丹')?>&debug" target="_blank">刷新一个词</a><br />
<a href="./index.php?class=history&method=hot&debug" target="_blank">热门词</a><br />
<a href="./index.php?class=history&method=lists&limit=1&word=<?php echo urlencode('体')?>&debug" target="_blank">联想词列</a><br />
<hr />
<a href="./index.php?class=fav&method=lists&uid=dabc&debug" target="_blank">收藏</a><br />
<a href="./index.php?class=fav&method=add&id=5&uid=dabc&debug" target="_blank">添加收藏</a><br />
<a href="./index.php?class=fav&method=delete&id=5&uid=dabc&debug" target="_blank">删除收藏</a><br />
<hr />
<a href="./index.php?class=tag&method=filter_tags&cid=17&tag=<?php echo urlencode('发烧/体温上升 脱水')?>&debug" target="_blank">某词选择后的指定栏目症状</a><br />
<a href="./index.php?class=tag&method=filter_tags_type&tag=<?php echo urlencode('发烧/体温上升 脱水')?>&debug" target="_blank">某词选择后的栏目</a><br />
<a href="./index.php?class=illness&method=tag_filter_list&tag=<?php echo urlencode('发烧/体温上升 脱水')?>&debug" target="_blank">某词选择后的推倒结果</a><br />

</body>
</html>

