<template>
	<ul>
		<li class="comment-box clearfix margint40 comment-blog"  v-for="comment in comments">
			<div class="col-lg-2 comment-author-image">
				<img alt="Blog Comments Image 1" class="img-circle"
				:src="messages.image">
			</div>
			<div class="col-lg-10">
				<h5 class="email-cmt">{{ comment.email }}</h5>
				<div class="date">{{ comment.date }}
				</div>
				<p class="body-cmt" :id="'body-cmt_' + comment.id">{{ comment.body }}</p>
				<div class="btn-action" v-for="cookie in messages.check.split(',')" v-if="comment.id == cookie">
					<span class="btn btn-danger" :comment_id="comment.id">{{ messages.delete1 }}</span>&nbsp;
					<span class="btn btn-warning">{{ messages.edit }}</span>
				</div>
				<div class="edit-cmt">
					<textarea :placeholder="messages.body"class="text-comment">
					</textarea>
					<button class="margint10 edit-submit btn btn-success" :id-cmt="comment.id">{{ messages.btn_submit }}</button>
				</div>
			</div>
		</li>
	</ul>
</template>
<script>
    export default {
		props: [
			'comments',
			'messages',
		],
	}
</script>
