<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 


$urlpatterns = [
  array(
    'path'=>'/admin/login/',
    'view'=>'admin_login',
    'name'=>'admin_login'
  ),
  array(
    'path'=>'/admin/(?P<table>\w+)/details/(?P<id>\d+)/',
    'view'=>'object_detail',
    'name'=>'object_detail'
  ),
  array(
    'path'=>'/admin/User/new/',
    'view'=>'create_user',
    'name'=>'create_user'
  ),
  
  array(
    'path'=>'/admin/(?P<table>\w+)/new/',
    'view'=>'object_create',
    'name'=>'object_create'
  ),
  array(
    'path'=>'/admin/(?P<table>\w+)/edit/(?P<id>\d+)/',
    'view'=>'object_edit',
    'name'=>'object_edit'
  ),
  array(
    'path'=>'/admin/(?P<table>\w+)/delete/(?P<id>\d+)/',
    'view'=>'object_delete',
    'name'=>'object_delete'
  ),
  array(
    'path'=>'/admin/(?P<table>\w+)/',
    'view'=>'object_list',
    'name'=>'object_list'
  ),
  array(
    'path'=>'/admin/',
    'view'=>'admin_dashboard',
    'name'=>'admin_dashboard'
  ),
  ];