#       微信接口搭建与开发

###     目录结构
            1.index.php             单一入口文件
            
            2.app                   开发者目录
                Entry.php           测试微信sdk(软件开发工具包)
                
            3.wechat                微信框架搭建  
              
                A->build            各种功能类目录
                    Button.php      自定义菜单功能
                    Message.php     消息管理器类
                    User.php        用户管理类
                    
                B->Wx.php           微信基础类        
                    