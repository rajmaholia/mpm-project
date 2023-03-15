<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 


$urlpatterns = [
  path(
    url:'/admin/login/',
    view:'admin_login',
    name:'admin_login'
  ),
  path(
    url:'/admin/(?P<table>\w+)/details/(?P<id>\d+)/',
    view:'object_detail',
    name:'object_detail'
  ),
  path(
    url:'/admin/User/new/',
    view:'create_user',
    name:'create_user'
  ),
  
  path(
    url:'/admin/(?P<table>\w+)/new/',
    view:'object_create',
    name:'object_create'
  ),
  path(
    url:'/admin/(?P<table>\w+)/edit/(?P<id>\d+)/',
    view:'object_edit',
    name:'object_edit'
  ),
  path(
    url:'/admin/(?P<table>\w+)/delete/(?P<id>\d+)/',
    view:'object_delete',
    name:'object_delete'
  ),
  path(
    url:'/admin/(?P<table>\w+)/',
    view:'object_list',
    name:'object_list'
  ),
  path(
    url:'/admin/',
    view:'admin_dashboard',
    name:'admin_dashboard'
  ),
  ];