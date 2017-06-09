# Introduction
A heartbeat can be used to monitor background processes that should regularly
trigger. The heartbeat can be linked to an external URL. This URL is pinged
when the heartbeat is triggered.

In WordPress an overview of triggered heartbeats, timestamps and environment
are shown in the `Tools`/`Heartbeat status` menu.

# Examples

## To trigger a heartbeat
```
use LL\Heartbeat\Heart;
Heart::beat('START_UPDATE_ALL', 'Updates all objects.');
```

## To trigger a URL ping
Add a define to `wp-config.php` which links the heartbeat context to a URL. The
context is prefixed with `LL_HB_` by default.

As an example:

In *envoyer.io* you can set a heartbeat under Project/Heartbeats/Add heartbeat.
Here you configure a name and the timing interval you expect the heartbeat to
trigger. The resulting URL is added to `wp-config.php`.

```
define('LL_HB_START_UPDATE_ALL', 'http://beats.envoyer.io/heartbeat/#####');
```
