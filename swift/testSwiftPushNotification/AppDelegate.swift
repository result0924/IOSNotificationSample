//
//  AppDelegate.swift
//  testSwiftPushNotification
//
//  Created by Kuan-Ting Lai on 2014/10/15.
//  Copyright (c) 2014年 com.h2sync.h2syncapp2. All rights reserved.
//

import UIKit

let Device = UIDevice.currentDevice()

private let iosVersion = NSString(string: Device.systemVersion).doubleValue

let iOS8 = iosVersion >= 8
let iOS7 = iosVersion >= 7 && iosVersion < 8

@UIApplicationMain

class AppDelegate: UIResponder, UIApplicationDelegate {

    var window: UIWindow?


    func application(application: UIApplication, didFinishLaunchingWithOptions launchOptions: [NSObject: AnyObject]?) -> Bool {
        // Override point for customization after application launch.
        
        if iOS8 {
            var types: UIUserNotificationType = UIUserNotificationType.Badge |
                UIUserNotificationType.Alert |
                UIUserNotificationType.Sound
            
            var settings: UIUserNotificationSettings = UIUserNotificationSettings( forTypes: types, categories: nil )
            
            application.registerUserNotificationSettings( settings )
            application.registerForRemoteNotifications()
        } else {
            application.registerForRemoteNotificationTypes( UIRemoteNotificationType.Badge |
                UIRemoteNotificationType.Sound |
                UIRemoteNotificationType.Alert )
        }
        
        
        return true
    }
    
    // get device token
    func application( application: UIApplication!, didRegisterForRemoteNotificationsWithDeviceToken deviceToken: NSData! ) {
        
        var characterSet: NSCharacterSet = NSCharacterSet( charactersInString: "<>" )
        
        var deviceTokenString: String = ( deviceToken.description as NSString )
            .stringByTrimmingCharactersInSet( characterSet )
            .stringByReplacingOccurrencesOfString( " ", withString: "" ) as String
        
        println( deviceTokenString )
        
    }
    
    // print notification error
    func application( application: UIApplication!, didFailToRegisterForRemoteNotificationsWithError error: NSError! ) {
        
        println( error.localizedDescription )
    }

    func application(application: UIApplication!, didReceiveRemoteNotification userInfo:NSDictionary!) {
        
        var notification:NSDictionary = userInfo.objectForKey("aps") as NSDictionary
        println( notification )
        
    }
    
    func applicationWillResignActive(application: UIApplication) {
        // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
        // Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
    }

    func applicationDidEnterBackground(application: UIApplication) {
        // Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later.
        // If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
    }

    func applicationWillEnterForeground(application: UIApplication) {
        // Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
    }

    func applicationDidBecomeActive(application: UIApplication) {
        // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
    }

    func applicationWillTerminate(application: UIApplication) {
        // Called when the application is about to terminate. Save data if appropriate. See also applicationDidEnterBackground:.
    }


}

