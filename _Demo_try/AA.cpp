 /*******************বিসমিল্লাহির রাহমানির রাহিম **********************/
 /*__________________ MD ASADUZZAMAN SHUVO ______________________ */

#include<bits/stdc++.h>
using namespace std;

#define ll long long
const int INF = 1e9+10;
const int N = 1e5+10;


int main() {
    int t;
    cin >> t;
    while (t--) {
        int n;cin >> n;
        string s;cin >> s;
        int zeros = 0, ones = 0;
        for (int i = 0; i < n; i++) {
            if (s[i] == '0')  zeros++;
            else ones++;
        }
        if (zeros > 0 ) cout << "YES" << endl;
        else  cout << "NO" << endl;
    }

    return 0;
}
