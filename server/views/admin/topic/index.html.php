{% extends admin/master.html.php %}

{% block title %}<?= $shop_name ?? 'SSF' ?> - Admin - Chủ đề{% endblock %}

{% block content %}

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Quản lý chủ đề</h1>
</div>

<div class="vh-100">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Media</th>
    </tr>
  </thead>
  <tbody>
  <?php $count = 1; ?>
  <?php foreach($topic_all as $topic): ?>
    <tr>
      <th scope="row"><?= $count++; ?></th>
      <td><?= $topic->title; ?></td>
      <td><?= $topic->description; ?></td>
      <td><?= $topic->media_id; ?></td>
    </tr>
  <?php endforeach;?>
  </tbody>
</table>
</div>

{% endblock %}
