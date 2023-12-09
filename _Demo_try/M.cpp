 /*******************বিসমিল্লাহির রাহমানির রাহিম **********************/
 /*__________________ MD ASADUZZAMAN SHUVO ______________________ */

#include<bits/stdc++.h>
using namespace std;

#define ll long long
const int INF = 1e9+10;
const int N = 1e5+10;

int main()
{
 int n ;cin>>n;
 vector<ll> v(n);
 for(int i = 0;i<n;i++) cin>>v[i];
 ll sum =0;
 for(int i = 0;i<n;i++) {
    sum+=v[i];
 }
ll d= 999999999999999999+10;
for(int i = 0;i<n ;i++){
    d = min(d,sum-v[i]);
}
cout<< min(d,sum/3) <<endl;
    return 0;
}