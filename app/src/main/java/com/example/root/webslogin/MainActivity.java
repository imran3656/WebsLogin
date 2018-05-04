package com.example.root.webslogin;

import android.graphics.Bitmap;
import android.support.v4.util.LruCache;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.TextView;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.ImageLoader;
import com.android.volley.toolbox.NetworkImageView;
import com.android.volley.toolbox.Volley;
public class MainActivity extends AppCompatActivity {
    TextView tv_name, tv_mobile, tv_email;
    NetworkImageView networkImageView;
    ImageLoader imageLoader;
    RequestQueue requestQueue;//To Download the use profile picture
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        setTitle("Android Easily - Welcome");
        //Initializing Widgets
        tv_name = (TextView) findViewById(R.id.textView9);
        tv_mobile = (TextView) findViewById(R.id.textView11);
        tv_email = (TextView) findViewById(R.id.textView13);
        networkImageView = (NetworkImageView) findViewById(R.id.imageView);
        requestQueue = Volley.newRequestQueue(MainActivity.this);
        imageLoader = new ImageLoader(requestQueue, new ImageLoader.ImageCache() {
            int cacheSize = 4 * 1024 * 1024; // 4 MegaBytes
            LruCache<String, Bitmap> lruCache = new LruCache<String, Bitmap>(cacheSize);
            @Override
            public Bitmap getBitmap(String url) {
                return lruCache.get(url);
            }
            @Override
            public void putBitmap(String url, Bitmap bitmap) {
                lruCache.put(url, bitmap);
            }
        });
        //Displaying the values passed from the LoginActivity
        tv_name.setText(getIntent().getStringExtra("name"));
        tv_email.setText(getIntent().getStringExtra("email"));
        tv_mobile.setText(getIntent().getStringExtra("mobile"));
        networkImageView.setImageUrl(getIntent().getStringExtra("url"), imageLoader);
    }
}