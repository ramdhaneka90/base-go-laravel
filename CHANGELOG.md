## Upgrade Steps

List out, as concretely as possible, any steps users have to take when they upgrade beyond just dumping the dependency.

- Add Column "is_fingerprint" in Table "users"

```
ALTER TABLE users ADD COLUMN is_fingerprint TinyInt(1) DEFAULT 1;
```