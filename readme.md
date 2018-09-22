> Demo base for laravel

#### Badages
```
[![build status](https://git.yoursite.com/web/laravel/badges/master/build.svg)](https://git.yoursite.com/web/laravel/commits/master)
[![coverage report](https://git.yoursite.com/web/laravel/badges/master/coverage.svg)](https://git.yoursite.com/web/laravel/commits/master)
```

#### 初始化开发环境
1. 拷贝`.env.example`至`.env`
2. 拷贝`docker-compose.example.yml`至`docker-compose.yml`
3. 执行`docker login git.yoursite.com:5005`使用`Gitlab`账号登录项目私有`docker`镜像仓库`Container Registry`
4. 运行`docker-compose pull && docker-compose up -d`拉取镜像并启动环境
5. 执行`docker exec nginx_phpfpm composer install --profile --prefer-dist --optimize-autoloader`安装`composer`依赖
6. 执行`docker exec nginx_phpfpm cnpm install`安装`node`依赖
7. 关闭环境`docker-compose down`

#### 日常开发工作
1. 执行`docker-compose up -d`启动开发环境
2. 执行`docker exec -it nginx_phpfpm bash`进入容器使用其提供的环境（退出容器请按键`CTRL + d`）：
  * PHP环境（调配优化）
  * Composer套件（调配优化）
  * NodeJS & NPM & CNPM & Yarn（调配优化）
  * Gulp套件
  * Bower套件
3. 在宿主机环境下`git`命令行提交代码
4. 关闭环境`docker-compose down`

#### 前端项目编译
1. 执行`docker exec nginx_phpfpm npm run dev`启动编译任务
2. 执行`docker exec nginx_phpfpm npm run watch`实时监控文件自动编译

#### 集群部署
* 为了思路清晰，项目涉及镜像、部署环境等的命名均以git分支为准
* feature、test部署使用docker测试集群，feature部署容器三天后自动下线并销毁
* staging、production部署使用docker生产集群
* 服务的集群部署使用8***端口开放服务，通过前端lbs将特定域名流量负载到特定集群端口
