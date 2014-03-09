<?php if ( ! isset($cid) ):?>
<ul class="breadcrumb">
    <li><a href="<?php e::url('/discuss/');?>">Discuss</a> <span class="divider">/</span></li>
</ul>
<form class="form-inline well" role="form" action="<?php e::url('/discuss');?>" method="GET">
    <div class="form-group">
        <label class="sr-only" for="pid">Problem Id</label>
        <input placeholder="Problem Id" name="pid" id="pid" class="form-control"/>
    </div>
    <div class="form-group">
        <label class="sr-only" for="uid">User Id</label>
        <input placeholder="User Id" name="uid" id="uid" class="form-control"/>
    </div>
    <input type="submit" value="Filter" class="btn">
    <a href="<?php e::url('/discuss/new');?>" class="btn btn-info pull-right">New Topic</a>
</form>
<?php else:?>
    <?php echo(View::factory('contest/header', array('title' => $title, 'cid' => Request::$current->query('cid'), 'contest' => $contest)));?>
<div class="well">
    <a href="<?php e::url('/discuss/new?cid=<?php echo($cid);?>');?>" class="btn btn-info">New Topic</a>
</div>
<?php endif;?>
<hr class="clearfix"/>
<?php if ( OJ::is_admin() ):?>
<form action="<?php e::url('discuss/batch');?>" method="post">
<?php endif;?>
<table class="table table-bordered">
    <thead>
    <tr>
        <?php if ( OJ::is_admin() ):?>
            <th><input type="checkbox" id="select-all-topic"/></th>
        <?php endif;?>
        <th class="col-sm-1"></th>
        <th>Title</th>
        <th class="col-sm-2">Author</th>
    </tr>
    </thead>
    <tbody>
    <?php /* @var Model_Topic[] $topic_list */ foreach ($topic_list as $t): ?>
    <tr>
        <?php if ( OJ::is_admin() ):?>
        <td>
            <input type="checkbox" name="tid[]" value="<?php echo($t->tid);?>"/>
        </td>
        <?php endif;?>
        <td>
            <?php if ($t->pid):?><a href="<?php e::url("problem/show/{$t->pid}");?>" style="color: #000000"> <?php echo($t->pid);?> </a><?php endif;?></td>
        <td>
            <a href="<?php e::url("t/{$t->tid}");?>"><strong><?php echo($t->title);?></strong></a>
        </td>
        <td><a href="<?php echo(Route::url('profile', array('uid' => $t->author_id)));?>"><?php echo($t->author_id);?></a></td>
    </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php if ( OJ::is_admin() ):?>
    <button name="action" value="deletetopic" class="btn btn-warning">Delete Topic</button> <button class="btn btn-danger" name="action" value="andblockuser">Delete And Block</button>
    </form>
<?php endif;?>
<ul class="pager double-side-pager">
    <?php $page = Request::$current->query('page');?>
    <?php if ($page != 1):?>
        <?php
        $params = Request::$current->query();
        $params['page'] = $page - 1;
        $query_param = URL::query($params);
        ?>
        <li class="previous"><?php e::anchor("discuss/{$query_param}", '&larr; Newer');?></li>
    <?php endif;?>
    <?php if ($page < $total): ?>
        <?php
        $params['page'] = $page + 1;
        $query_param = URL::query($params);
        ?>
        <li class="next"><?php e::anchor("discuss/{$query_param}", 'Older &rarr;');?></li>
    <?php endif;?>
</ul>