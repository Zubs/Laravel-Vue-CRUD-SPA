<template>
	<div>
		<h2 class="mt-3 mb-3" style="text-align: center;">Our Teachers</h2>
		<form @submit.prevent="addTeacher">
			<div class="row">
				<div class="col-5">
					<div class="form-group">
						<input type="text" placeholder="Enter Teacher Name" class="form-control" v-model="teacher.name">
					</div>
				</div>
				<div class="col-5">
					<div class="form-group">
						<input type="number" placeholder="Enter Teacher Price" class="form-control" v-model="teacher.price">
					</div>
				</div>
				<div class="col-2">
					<div class="form-group">
						<button class="btn form-control btn-primary" type="submit">ADD</button>
					</div>
				</div>
			</div>
		</form>
		<nav>
			<ul class="pagination">
				<li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]"><a href="#" class="page-link" @click="fetchTeachers(pagination.prev_page_url)">Previous</a></li>
				<li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
				<li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]"><a href="#" class="page-link" @click="fetchTeachers(pagination.next_page_url)">Next</a></li>
			</ul>
		</nav>
		<div v-for="teacher in teachers" v-bind:key="teacher.id" class="card card-body mb-3">
			<h3>{{ teacher.name }}<span style="float: right;">${{ teacher.price }}</span></h3>
			<div class="row mt-3">
				<div class="col-6">
					<button class="btn btn-warning form-control" @click="editTeacher(teacher)">Edit</button>
				</div>
				<div class="col-6">
					<button class="btn btn-danger form-control" @click="deleteTeacher(teacher.id)">Delete</button>
				</div>
				
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				teachers: [],
				teacher: {
					id: '',
					name: '',
					price: ''
				},
				teacher_id: '',
				pagination: {},
				edit: false
			}
		},

		created() {
			this.fetchTeachers();
		},

		methods: {
			fetchTeachers(page_url) {
				let vm = this;
				page_url = page_url || '/api/teachers';
				fetch(page_url)
					.then(res => res.json())
					.then(res => {
						this.teachers = res.data;
						vm.makePagination(res.meta, res.links);
					})
					.catch(err => console.log(err));
			},
			makePagination(meta, links) {
				let pagination = {
					current_page: meta.current_page,
					last_page: meta.last_page,
					next_page_url: links.next,
					prev_page_url: links.prev
				}
				this.pagination = pagination;
			},
			deleteTeacher(id) {
				if(confirm('You sure you wanna delete?')) {
					fetch(`api/teacher/${id}`, {
						method: 'delete'
					})
						.then(res => res.json())
						.then(data => {
							alert('Teacher Removed');
							this.fetchTeachers();
						})
						.catch(err => console.log(err))
				}
			},
			addTeacher() {
				if(this.edit === false) {
					fetch('api/teacher', {
						method: 'post',
						body: JSON.stringify(this.teacher),
						headers: {
							'content-type': 'application/json'
						}
					})
						.then(res => res.json())
						.then(data => {
							this.teacher.name = '';
							this.teacher.price = '';
							alert('Teacher Added Succesfully');
							this.fetchTeachers();
						})
						.catch(err => console.log(err))
				} else {
					fetch('api/teacher', {
						method: 'put',
						body: JSON.stringify(this.teacher),
						headers: {
							'content-type': 'application/json'
						}
					})
						.then(res => res.json())
						.then(data => {
							this.teacher.name = '';
							this.teacher.price = '';
							alert('Teacher Updated Succesfully');
							this.fetchTeachers();
						})
						.catch(err => console.log(err))
				}
			},
			editTeacher(teacher) {
				this.edit = true;
				this.teacher.id = teacher.id;
				this.teacher_id = teacher.id;
				this.teacher.name = teacher.name;
				this.teacher.price = teacher.price;
			}
		}
	}
</script>