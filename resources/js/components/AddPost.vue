<template>
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-5 card">
                <div class="card-header">
                    Blog - Add Post
                </div>
                <div class="card-body">
                    <form action="" method="post" data-parsley-validate>
                        <div class="form-group">
                            <input type="hidden" v-model="blog.id" />
                            <input
                                type="text"
                                class="form-control"
                                v-model="blog.title"
                                placeholder="Title Post..."
                                required
                            />
                        </div>
                        <div class="form-group">
                            <textarea
                                v-model="blog.body"
                                class="form-control"
                                cols="30"
                                rows="5"
                                placeholder="Body Post..."
                                required
                            ></textarea>
                        </div>
                        <button
                            type="button"
                            class="btn btn-primary float-right"
                            v-show="btnStore"
                            @click="store"
                        >
                            Publish
                        </button>
                        <button
                            type="button"
                            class="btn btn-success float-right"
                            v-show="btnUpdate"
                            @click="update"
                        >
                            Update
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary mr-1 float-right"
                            v-show="btnUpdate"
                            @click="cancel"
                        >
                            Cancel
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-4">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li
                            class="page-item"
                            :class="[{ disabled: !pagination.prev_page_url }]"
                        >
                            <a
                                class="page-link"
                                href=""
                                @click.prevent="
                                    fetchBlogs(pagination.prev_page_url)
                                "
                                >Previous</a
                            >
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link text-dark">
                                {{ pagination.current_page }} of {{ pagination.last_page }}
                            </a>
                        </li>
                        <li
                            class="page-item"
                            :class="[{ disabled: !pagination.next_page_url }]"
                        >
                            <a
                                class="page-link"
                                href=""
                                @click.prevent="
                                    fetchBlogs(pagination.next_page_url)
                                "
                                >Next</a
                            >
                        </li>
                    </ul>
                </nav>
                <span class="list-group" v-for="blog in blogs" v:key="blog.id">
                    <li class="list-group-item">
                        {{ blog.title }} - {{ blog.body }}
                        <div class="float-right">
                            <span
                                class="badge badge-success badge-pill btn"
                                @click="edit(blog)"
                                >edit</span
                            >
                            <span
                                class="badge badge-danger badge-pill btn"
                                @click="destroy(blog.id)"
                                >delete</span
                            >
                        </div>
                    </li>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            blogs: [],
            blog: {
                id: null,
                title: "",
                body: ""
            },
            btnStore: true,
            btnUpdate: false,
            pagination: {}
        };
    },
    created() {
        this.fetchBlogs();
    },
    methods: {
        fetchBlogs(url) {
            var page_url = url || "/blog/fetch/all";
            axios.get(page_url).then(res => {
                var response = res.data;
                this.blogs = response.data;
                this.makePagination(
                    response.current_page,
                    response.last_page,
                    response.next_page_url,
                    response.prev_page_url
                );
            });
        },
        makePagination(current_page, last_page, next_page_url, prev_page_url) {
            let pagination = {
                current_page: current_page,
                last_page: last_page,
                next_page_url: next_page_url,
                prev_page_url: prev_page_url
            };
            this.pagination = pagination;
        },
        store() {
            axios
                .post("/blog", this.blog)
                .then(res => {
                    this.clearForm();
                    this.fetchBlogs();
                })
                .catch(err => {});
        },
        destroy(id) {
            var del = confirm();
            if (del) {
                axios.delete(`/blog/${id}`).then(res => {
                    this.fetchBlogs();
                    this.clearForm();
                });
            }
        },
        edit(blog) {
            this.blog.id = blog.id;
            this.blog.title = blog.title;
            this.blog.body = blog.body;
            this.btnStore = false;
            this.btnUpdate = true;
        },
        update() {
            axios.put(`/blog/${this.blog.id}`, this.blog).then(res => {
                this.fetchBlogs();
                this.clearForm();
            });
        },
        cancel() {
            this.clearForm();
            this.btnStore = true;
            this.btnUpdate = false;
        },
        clearForm() {
            this.blog.id = "";
            this.blog.title = "";
            this.blog.body = "";
        }
    }
};
</script>

<style></style>
