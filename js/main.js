
(function($) {
	function validateInput(el,pattern){
		if(el.val().search(pattern)==0)
			el.addClass('border-success').removeClass('border-danger');
		else
			el.addClass('border-danger').removeClass('border-success');
	}

	function validated(el){
		if (!el.hasClass('border-danger'))
			return	true;
	}

	var user;

	$(document).ready(function() {
		var patternLogin=/^[a-zа-я0-9_-]+$/i;
		var patternPassword=/^((?=.*\d)(?=.*[A-Z]).{8,})$/;
		var patternEmail=/^[a-z0-9\._-]+@[a-z0-9-]+\.([a-z]{1,6}\.)?[a-z]{2,}$/i;

		$('body').on('blur', '#email' ,function(e){
					validateInput($(this), patternEmail);
		});

		$('body').on('blur', '#user' ,function(e){
					validateInput($(this), patternLogin);
		});

		$('body').on('blur', '#task' ,function(e){
			if($(this).val()!="")
				$(this).addClass('border-success').removeClass('border-danger');
			else
				$(this).addClass('border-danger').removeClass('border-success');

		});

		getCurrentUser();
		getTasks(1);

		function getCurrentUser(){
			$.ajax({
				url: './',
				method: 'get',
				data:{
					route:'/api/getCurrentUser'
				},
				dataType: 'json',
				success: function(data){
					if (data.login!="guest"){
						$('#loginDropDown').hide();
						$('#authUser').show();
						user=data.login;
						$('#userAuth').text('Пользователь: '+data.login);
					}
				}
			});
		}

		function getTasks(page){

			$.ajax({
				url: './',
				method: 'get',
				data:{
					route:'/api/getPageCount'
					},
				dataType: 'json',
				success: function(data){
					var html="";
					var index;
					for (index = 1; index <= data['page_count']; index++) {
						html+='<li  class="page-item page-task" id="page-'+index+'"><a class="page-link" >'+index+'</a></li>';
					}
					$('.page-task').remove();
					$('#previos').after( html);
					$('#page-'+page).addClass("active");
					}
				});

			$.ajax({
				url: './',
				method: 'get',
				data:{
						route:'/api/getTasks',
						sort:$( "#select-sort" ).val(),
						page:page
						},
				dataType: 'json',
				success: function(data){
						$('#tasks').html("");
						var html="";
						$.each(data, function(i, jsondatas){
							html+='<div  class="card mb-2" id="task_'+jsondatas.id+'" data-activated="'+jsondatas.activated+'">'	+
								'	<div class="card-body">';

							if (user!=null)
							{
							html+='		<div class="row mr-3 justify-content-end">'+
								'<button type="button" class="btn btn-primary btn-sm" id="editBtn" data-id="'+jsondatas.id+'">Редактировать</button>'+
								'		</div>		';
							}
							html+='		<div class="row mt-3">'+
								'			<div class="col-md-8" id="task_text">'+jsondatas.text+'</div>	'+
								'		</div>		'+
								'		<div class="row mt-3 justify-content-center">'+
								'			<div class="col-lg-4">Пользователь: <span id="user_name">'+jsondatas.user_name+'</span></div> <div class="col-lg-4"> E-mail: <span id="user_email">'+jsondatas.email+'</span></div>';
							if (jsondatas.activated==1)
								html+='			<div class="col-lg-4"> статус: выполнено</div>';
							else
								html+='			<div class="col-lg-4"> статус: не выполнено</div>';

							html+='		</div>	'+
								'	</div>'+
								'</div>';
							});
						$('#tasks').append(html);

					}
				});
		}

		$('#select-sort').on('change', function() {
			getTasks(1);
			});

		$('.pagination').on('click', 'li', function() {
			var page, lastPage;
			var activePage=Number($(".pagination").find('.active').text());
			if ($(this).attr('id')=="previos")
				{
				if (activePage>1)
					page=activePage-1;
				else
					page=1;
				}
			else if  ($(this).attr('id')=="next")
				{
				lastPage=Number($(".page-task").last().text());
				if (activePage<lastPage)
					page=activePage+1;
				else
					page=lastPage;
				}
			else
				page=$(this).text();

			getTasks(page);
			});

		$('body').on('click', '#addTask', function() {
			$("#addForm").remove();
			$("#editForm").remove();
			let html='<form id="addForm" name="addForm" >'+
				'	<div class="card">'+
				'		<div class="card-header text-center">'+
				'			<h2>Добавить задачу</h2>'+
				'		</div>'+
				'		<div class="card-body">'+
				'			<div class="row mt-3 ">'+
				'				<label for="user" class="col-md-3 col-form-label">Ваше имя</label>'+
				'				<div class="col-md-4">'+
				'					<input type="text" class="form-control" id="user" name="user" placeholder="имя">'+
				'				</div>'+
				'			</div>'+
				'			<div class="row mt-3 ">'+
				'				<label for="email" class="col-md-3 col-form-label">E-mail</label>'+
				'				<div class="col-md-4">'+
				'					<input type="email" class="form-control" id="email" name="email" placeholder="E-mail">'+
				'				</div>'+
				'			</div>'	+
				'			<div class="row mt-3 ">'+
				'				<label for="task" class="col-md-3 col-form-label">Текст задачи</label>'+
				'				<div class="col-md-9">'+
				'					<textarea class="form-control" id="task" rows="3"></textarea>'+
				'				</div>'+
				'			</div>'+
				'			<div class="row mt-3 justify-content-center">'+
				'				<input type="button" class="btn mt-3 btn-primary mr-2" id="addBtn"  value="Добавить" />'+
				'				<input type="button" class="btn mt-3 btn-primary" id="cancelBtn"  value="Отмена" />'+
				'			</div>'+
				'		</div>'+
				'	</div>'+
				'</form>';
			$("#tasks-block").before(html);
			});

		$('body').on('click', '#cancelBtn', function() {
			$("#addForm").hide();
			$("#editForm").hide();
			});

		$('body').on('click', '#addBtn', function() {
			if ((validated($("#user")))&&(validated($("#email")))&&(validated($("#task"))))
				{
				$.ajax({
						url: './',
						method: 'get',
						data:{
								route:'/api/addTasks',
								name:$( "#addForm" ).find('input[name="user"]').val(),
								email:$( "#addForm" ).find('input[name="email"]').val(),
								task:$( "#addForm" ).find('textarea').val(),
								},
						dataType: 'json',
						success: function(data){
							if (data.message=="Задание успешно сохранено!")
								{
								$('#tasks-block').before('<div class="alert alert-success" role="alert">Задание успешно сохранено!</div>');
								$("#addForm").remove();
								getTasks(1);
								}
							else
								$('#tasks-block').before('<div class="alert alert-danger" role="alert">'+data.message+'</div>');
							$(".alert").fadeOut(5000);
						}
					});
				}
			else
				$('#tasks-block').before('<div class="alert alert-danger" role="alert">Заполните правильно все поля</div>');
				$(".alert").fadeOut(5000);
			});

		$(window).click(function(event) {
			var dropdownLogin=$('#signInDropdown');
			if (event.target.id=='signIn')
				{
				if (dropdownLogin.is(':visible'))
					{
					$('#signIn').text("Войти");
					dropdownLogin.css('display','none');
					}
				else
					{
					$('#signIn').text("Авторизация");
					dropdownLogin.css('display','block');
					}
				}
			else
				{
				if ((dropdownLogin.is(':visible'))&&($("#signInDropdown").find(event.target).length==0 ))
					{
					$('#signIn').text("Войти");
					dropdownLogin.css('display','none');
					}
				}
			});


		$('body').on('click', '#signInBtn', function() {
			$.ajax({
				url: './',
				method:'get',
				data:{
						route:'/api/login',
						login:$( "input[name='login']" ).val(),
						password:$( "input[name='password']" ).val()
						},
				dataType: 'json',
				success: function(data){
					console.log(data);
					if (data.message=="Авторизован")
						{
						$('#loginDropDown').hide();
						$('#authUser').show();
						user=data.login;
						$('#userAuth').text('Пользователь: '+data.login);
						getTasks(1);
						}
					else
						{
						$('#tasks-block').before('<div class="alert alert-danger" role="alert">Ошибка авторизации!</div>');
						$(".alert").fadeOut(5000);
						}
					}
				});
			});

		$('body').on('click', '#exitBtn', function() {
			$.ajax({
				url: './',
				method: 'get',
				data:{
					route:'/api/logOut'
					},
				dataType: 'json',
				success: function(data){
					if (data.message=="Exit"){
						$('#authUser').hide();
						$('#loginDropDown').show();
						$('#signInDropdown').hide();
						$('#signIn').text('Войти');
						$('input[name="loginSignIn"]').val("");
						$('input[name="Password"]').val("");
						user=null;
						getTasks(1);
						}
					}
				});
			});

		$('body').on('click', '#editBtn', function() {
			$("#addForm").remove();
			$("#editForm").remove();
			let task_id=$(this).attr('data-id');
			let html='<form id="editForm" name="editForm" >'+
				'	<div class="card">'+
				'		<div class="card-header text-center">'+
				'			<h2>Редактирование задачи</h2>'+
				'		</div>'+
				'		<div class="card-body">'+
				'			<input  name="id" type="hidden" value="'+task_id+'">'+
				'			<div class="row mt-3 ">'+
				'				<label for="user" class="col-md-3 col-form-label">Имя пользователя</label>'+
				'				<div class="col-md-4">'+
				'					<input type="text" class="form-control" id="user" name="user" placeholder="имя" disabled value="'+$("#task_"+task_id).find("#user_name").text()+'" >'+
				'				</div>'+
				'			</div>'+
				'			<div class="row mt-3 ">'+
				'				<label for="email" class="col-md-3 col-form-label">E-mail</label>'+
				'				<div class="col-md-4">'+
				'					<input type="email" class="form-control" id="email" name="email" placeholder="E-mail"  disabled value="'+$("#task_"+task_id).find("#user_email").text()+'" >'+
				'				</div>'+
				'			</div>'	+
				'			<div class="row mt-3 ">'+
				'				<label for="task" class="col-md-3 col-form-label">Текст задачи</label>'+
				'				<div class="col-md-9">'+
				'					<textarea class="form-control" id="task" rows="3">'+$("#task_"+task_id).find("#task_text").text()+'</textarea>'+
				'				</div>'+
				'			</div>'+
				'			<div class="row mt-3">'+
				'				'+
				'				<label for="status" class="col-md-3 col-form-label" >Выполнено</label>';
				if ($("#task_"+task_id).attr('data-activated')==1)
					html+='         <input type="checkbox"  class="ml-3"  id="status" checked="checked">	';

				else
					html+='         <input type="checkbox"  class="ml-3" id="status">	';

				html+='			'+
				'			</div>'+
				'			<div class="row mt-3 justify-content-center">'+
				'				<input type="button" class="btn mt-3 btn-primary mr-2" id="saveBtn"  value="Cохранить" />'+
				'				<input type="button" class="btn mt-3 btn-primary" id="cancelBtn"  value="Отмена" />'+
				'			</div>'+
				'		</div>'+
				'	</div>'+
				'</form>';
			$("#tasks-block").before(html);
			});

		$('body').on('click', '#saveBtn', function() {
			$.ajax({
					url: './',
					method:'get',
					data:{
							route:'/api/updateTask',
							id:$('#editForm').find('input[name="id"]').val(),
							text:$('#editForm').find('#task').val(),
							status:Number($('#editForm').find('#status').is( ':checked' ))
							},
					dataType: 'json',
					success: function(data)
					{
						if (data.message=="Изменения сохранены!")
							{
							$('#tasks-block').before('<div class="alert alert-success" role="alert">'+data.message+'</div>');
							$("#editForm").remove();
							getTasks(1);
							}
						else
							$('#tasks-block').before('<div class="alert alert-danger" role="alert">'+data.message+'</div>');
						$(".alert").fadeOut(5000);
					}
				});
			});

	});
})(jQuery);
