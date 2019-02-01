		<div class="row mt-3 justify-content-center">	
			<div class="col-md-4 mb-2">
				<h2>Задачи</h2> 
			</div>		
			<div class="col-md-3 mb-2">
				<input type="button" class="btn  btn-primary" id="addTask"  value="Добавить задачу" />			
			</div>				
			<div class="col-md-5 mb-2">		
				<div class="input-group mb-3">
				  <div class="input-group-prepend">
					<label class="input-group-text" for="select-sort">Сортировка задач</label>
				  </div>
				  <select class="custom-select" id="select-sort">
					<option selected value="0">Выберите...</option>
					<option value="1">по имени пользователя</option>
					<option value="2">по e-mail</option>
					<option value="3">по статусу</option>					
				  </select>
				</div>								
			</div>						
		</div>	
		<div id="tasks-block">
			<div id="tasks">				
			</div>
			<nav aria-label="Page navigation">
				  <ul class="pagination">
					<li id="previos" class="page-item">
					  <a class="page-link"  aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
						<span class="sr-only">Previous</span>
					  </a>
					</li>
					
					<li id="next" class="page-item">
					  <a class="page-link"  aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
						<span class="sr-only">Next</span>
					  </a>
					</li>
				  </ul>
			</nav>
		</div>	