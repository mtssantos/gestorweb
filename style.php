<?php
    header("Content-type: text/css");
?>

@import url(https://fonts.googleapis.com/css?family=Roboto);

.arealogin{
    margin-top: 20vh; 
    margin: 20vh auto;
    max-width: 600px;
}

body{
    background-color: #1C3341;
    color: white;
    <!-- background-color: #c5c5c5; -->
}

.navbar-brand {
  padding-top: .75rem;
  padding-bottom: .75rem;
  background-color: rgba(28, 51, 65, .75);
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
}

.navbar .navbar-toggler {
  top: .25rem;
  right: 1rem;
}


.navbar .form-control {
  padding: .75rem 1rem;
}

.sidebar {
  position: fixed;
  top: 0;
  /* rtl:raw:
  right: 0;
  */
  bottom: 0;
  /* rtl:remove */
  left: 0;
  z-index: 100; /* Behind the navbar */
  padding: 48px 0 0; /* Height of navbar */
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}


.sidebar-sticky {
  height: calc(100vh - 48px);
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
  background-color: rgba(28, 51, 65, .90);
}

.sidebar .nav-link {
  font-weight: 500;
  color: #fff;
}

.sidebar .nav-link .feather {
  margin-right: 4px;
  color: #fff;
}

.sidebar .nav-link.active {
  color: #2470dc;
}

.sidebar .nav-link:hover .feather,
.sidebar .nav-link.active .feather {
  color: inherit;
}

.sidebar-heading {
  font-size: .75rem;
}

.border-left-primary {
  border-left: 0.25rem solid #4e73df !important;
}

.border-bottom-primary {
  border-bottom: 0.25rem solid #4e73df !important;
}

.border-left-secondary {
  border-left: 0.25rem solid #858796 !important;
}

.border-bottom-secondary {
  border-bottom: 0.25rem solid #858796 !important;
}

.border-left-success {
  border-left: 0.25rem solid #1cc88a !important;
}

.border-bottom-success {
  border-bottom: 0.25rem solid #1cc88a !important;
}

.border-left-info {
  border-left: 0.25rem solid #36b9cc !important;
}

.border-bottom-info {
  border-bottom: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
  border-left: 0.25rem solid #f6c23e !important;
}

.border-bottom-warning {
  border-bottom: 0.25rem solid #f6c23e !important;
}

.border-left-danger {
  border-left: 0.25rem solid #e74a3b !important;
}

.border-bottom-danger {
  border-bottom: 0.25rem solid #e74a3b !important;
}

.border-left-light {
  border-left: 0.25rem solid #f8f9fc !important;
}

.border-bottom-light {
  border-bottom: 0.25rem solid #f8f9fc !important;
}

.border-left-dark {
  border-left: 0.25rem solid #5a5c69 !important;
}

.border-bottom-dark {
  border-bottom: 0.25rem solid #5a5c69 !important;
}

.textsucess{
  color: #1cc88a !important;
}

.textprimary{
  color: #4e73df !important; 
}

.card{
    background-color: rgba(28, 51, 65, .75);
    <!-- background-color: #c5c5c5; -->
}

.btn-enviar{
    margin-bottom: 6px;
}

.input-date{
  margin-right: 6px;
}

#chart{
  width: 700px;
}

.navbar-nav-responsive{
  display: none;
}

@media (max-width: 500px)
{
  main {
    width: 100%;
    padding-right: var(--bs-gutter-x,.75rem);
    padding-left: var(--bs-gutter-x,.75rem);
    margin-right: auto;
    margin-left: auto;
 }
 .navbar-nav{
  display: none;
 }
 .navbar-nav-responsive{
  display: block;
 }
}


